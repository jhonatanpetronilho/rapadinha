<?php

namespace App\Traits\Gateways;

use App\Models\AffiliateHistory;
use App\Models\Deposit;
use App\Models\DigitoPayPayment;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\NewDepositNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Core as Helper;

trait DigitoPayTrait
{
    /**
     * @var $uri
     * @var $clienteId
     * @var $clienteSecret
     */
    protected static string $bearerToken;
    protected static string $uri;

    /**
     * Generate Credentials
     * Metodo para gerar credenciais
     */
    private static function digitoPayGenerateCredentials()
    {
        $setting = Gateway::first();
        if(!empty($setting)) {
            self::$uri = $setting->getAttributes()['digitopay_uri'];
            $clientId = $setting->getAttributes()['digitopay_cliente_id'];
            $clienteSecret = $setting->getAttributes()['digitopay_cliente_secret'];

            $response = Http::post(self::$uri.'token/api',
                [
                    "clientId" => $clientId,
                    "secret" => $clienteSecret
                ]);
            
            // Log para debug - autenticação
            Log::info('DigitoPay Auth Response:', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->body()
            ]);
            
            if ($response->successful() && $response->object()) {
                self::$bearerToken = $response->object()->accessToken;
                Log::info('DigitoPay Token Generated Successfully');
            } else {
                Log::error('DigitoPay Token Generation Failed');
            }
        }
    }

    /**
     * Request QRCODE
     * Metodo para solicitar uma QRCODE PIX
 * @return array
     */
    public static function digitoPayRequestQrcode($request)
    {
        $setting = Helper::getSetting();
        $rules = [
            'amount' => ['required', 'numeric', 'min:'.$setting->min_deposit, 'max:'.$setting->max_deposit],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        self::digitoPayGenerateCredentials();

        // Verificar se o token foi inicializado
        if (!isset(self::$bearerToken)) {
            return response()->json([
                'error' => true,
                'message' => 'Falha na autenticação com o gateway de pagamento'
            ]);
        }

        // Gerar CPF válido dinamicamente
        $generatedCpf = $this->generateValidCpf();

        $response = Http::withToken(self::$bearerToken)->post(self::$uri.'deposit', [
            "dueDate" => Carbon::now()->addDay(),
            "paymentOptions" => ["PIX"],
            "person" => [
                "cpf" => $generatedCpf,
                "name" => auth('api')->user()->name,
            ],
            "value" => $request->amount,
            "callbackUrl" => url('/api/digitopay/callback'),
            "idempotencyKey" => \Illuminate\Support\Str::uuid()->toString()
        ]);

        if($response && $response->successful()) {
            $responseData = $response->json();
            
            // Log para debug - verificar resposta da API
            Log::info('DigitoPay Response:', $responseData);
            
            $transaction = self::digitoPayGenerateTransaction($responseData['id'], Helper::amountPrepare($request->amount), false); /// gerando historico
            self::digitoPayGenerateDeposit($responseData['id'], Helper::amountPrepare($request->amount)); /// gerando deposito

            return [
                'status' => true,
                'idTransaction' => $transaction->id,
                'qrcode' => $responseData['pixCopiaECola'],
                'qrCodeBase64' => $responseData['qrCodeBase64'] ?? null
            ];
        }

        // Log para debug - erro na resposta
        Log::error('DigitoPay Error Response:', [
            'status' => $response ? $response->status() : 'No response',
            'body' => $response ? $response->body() : 'No response body'
        ]);
        
        return [
            'status' => false,
        ];
    }

    /**
     * Consult Status Transaction
     * Consultar o status da transação

     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function digitoPayConsultStatusTransaction($request)
    {

        self::digitoPayGenerateCredentials();

        // Verificar se o token foi inicializado
        if (!isset(self::$bearerToken)) {
            return response()->json([
                'error' => true,
                'message' => 'Falha na autenticação com o gateway de pagamento'
            ]);
        }

        $transaction = Transaction::where('id', $request->idTransaction)->first();

        $response = Http::withToken(self::$bearerToken)->get(self::$uri.'status/'.$transaction->payment_id);
        
        // Log para debug - verificar resposta da consulta de status
        Log::info('DigitoPay Status Response:', [
            'url' => self::$uri.'status/'.$transaction->payment_id,
            'status_code' => $response ? $response->status() : 'No response',
            'body' => $response ? $response->body() : 'No response body'
        ]);
        
        if($response->successful()) {
            $responseData = $response->object();

            if($responseData == "REALIZADO")
            {
                if(self::digitoPayFinalizePayment($transaction->payment_id)) {
                    return response()->json(['status' => 'PAID']);
                }

                return response()->json(['status' => $responseData], 400);
            }

            return response()->json(['status' => $responseData], 400);

        }
        
        // Log para debug - erro na consulta de status
        Log::error('DigitoPay Status Error:', [
            'status' => $response ? $response->status() : 'No response',
            'body' => $response ? $response->body() : 'No response body'
        ]);
        
        return response()->json(['status' => 'ERROR'], 400);

    }

    /**
     * @param $idTransaction

     * @return bool
     */
    public static function digitoPayFinalizePayment($idTransaction) : bool
    {
        $transaction = Transaction::where('payment_id', $idTransaction)->where('status', 0)->first();
        $setting = Helper::getSetting();

        if(!empty($transaction)) {
            $user = User::find($transaction->user_id);

            $wallet = Wallet::where('user_id', $transaction->user_id)->first();
            if(!empty($wallet)) {

                /// verifica se é o primeiro deposito, verifica as transações, somente se for transações concluidas
                $checkTransactions = Transaction::where('user_id', $transaction->user_id)
                    ->where('status', 1)
                    ->count();

                if($checkTransactions == 0 || empty($checkTransactions)) {
                    if($transaction->accept_bonus) {
                        /// pagar o bonus
                        $bonus = Helper::porcentagem_xn($setting->initial_bonus, $transaction->price);
                        $wallet->increment('balance_bonus', $bonus);

                        if(!$setting->disable_rollover) {
                            $wallet->update(['balance_bonus_rollover' => $bonus * $setting->rollover]);
                        }
                    }
                }

                /// rollover deposito
                if($setting->disable_rollover == false) {
                    $wallet->increment('balance_deposit_rollover', ($transaction->price * intval($setting->rollover_deposit)));
                }

                /// acumular bonus
                Helper::payBonusVip($wallet, $transaction->price);

                /// quando tiver desativado o rollover, ele manda o dinheiro depositado direto pra carteira de saque
                if($setting->disable_rollover) {
                    $wallet->increment('balance_withdrawal', $transaction->price); /// carteira de saque
                }else{
                    $wallet->increment('balance', $transaction->price); /// carteira de jogos, não permite sacar
                }

                if($transaction->update(['status' => 1])) {
                    $deposit = Deposit::where('payment_id', $idTransaction)->where('status', 0)->first();
                    if(!empty($deposit)) {

                        /// fazer o deposito em cpa
                        $affHistoryCPA = AffiliateHistory::where('user_id', $user->id)
                            ->where('commission_type', 'cpa')
                            //->where('deposited', 1)
                            //->where('status', 0)
                            ->first();

                        if(!empty($affHistoryCPA)) {
                            /// faz uma soma de depositos feitos pelo indicado
                            $affHistoryCPA->increment('deposited_amount', $transaction->price);

                            /// verifcia se já pode receber o cpa
                            $sponsorCpa = User::find($user->inviter);

                            /// verifica se foi pago ou nnão
                            if(!empty($sponsorCpa) && $affHistoryCPA->status == 'pendente') {

                                if($affHistoryCPA->deposited_amount >= $sponsorCpa->affiliate_baseline || $deposit->amount >= $sponsorCpa->affiliate_baseline) {
                                    $walletCpa = Wallet::where('user_id', $affHistoryCPA->inviter)->first();

                                    if(!empty($walletCpa)) {

                                        /// paga o valor de CPA
                                        $walletCpa->increment('refer_rewards', $sponsorCpa->affiliate_cpa); /// coloca a comissão
                                        $affHistoryCPA->update(['status' => 1, 'commission_paid' => $sponsorCpa->affiliate_cpa]); /// desativa cpa
                                    }
                                }
                            }
                        }

                        if($deposit->update(['status' => 1])) {
                            $admins = User::where('role_id', 0)->get();
                            foreach ($admins as $admin) {
                                $admin->notify(new NewDepositNotification($user->name, $transaction->price));
                            }

                            return true;
                        }
                        return false;
                    }
                    return false;
                }

                return false;
            }
            return false;
        }
        return false;
    }

    /**
     * @param $idTransaction
     * @param $amount
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     * @return void
     */
    private static function digitoPayGenerateDeposit($idTransaction, $amount)
    {
        $userId = auth('api')->user()->id;
        $wallet = Wallet::where('user_id', $userId)->first();

        Deposit::create([
            'payment_id'=> $idTransaction,
            'user_id'   => $userId,
            'amount'    => $amount,
            'type'      => 'pix',
            'currency'  => $wallet->currency,
            'symbol'    => $wallet->symbol,
            'status'    => 0
        ]);
    }

    /**
     * @param $idTransaction
     * @param $amount
     * @dev victormsalatiel - Corra de golpista, me chame no instagram
     * * Use Digitopay - o melhor gateway de pagamentos para sua plataforma - 048 98814-2566
     * @return void
     */
    private static function digitoPayGenerateTransaction($idTransaction, $amount, $accept_bonus)
    {
        $setting = Helper::getSetting();

        return Transaction::create([
            'payment_id' => $idTransaction,
            'user_id' => auth('api')->user()->id,
            'payment_method' => 'pix',
            'price' => $amount,
            'currency' => $setting->currency_code,
            'accept_bonus' => $accept_bonus,
            'status' => 0
        ]);

    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public static function digitoPayPixCashOut(array $array): bool
    {
        self::digitoPayGenerateCredentials();

        // Verificar se o token foi inicializado
        if (!isset(self::$bearerToken)) {
            return false;
        }

        $response = Http::withToken(self::$bearerToken)->post(self::$uri.'api/withdraw', [
            "paymentOptions" => ["PIX"],
            "person" => [
                "pixKeyTypes" => self::FormatPixType($array['pix_type']),
                "pixKey" => $array['pix_key']
            ],
            "value" => $array['amount']
        ]);

        if($response->successful()) {
            $responseData = $response->json();
            $digitoPayPayment = DigitoPayPayment::lockForUpdate()->find($array['digitoPayPayment_id']);
            if(!empty($digitoPayPayment)) {
                if($digitoPayPayment->update(['status' => 1, 'payment_id' => $responseData['id']])) {
                    return true;
                }
                return false;
            }
            return $responseData['success'];
        }
        return false;
    }

    /**
     * @param $type
     * @return string|void
     */
    private static function FormatPixType($type)
    {
        switch ($type) {
            case 'email':
                return 'EMAIL';
            case 'document' && strlen($type) == 11:
                return 'CPF';
            case 'document' && strlen($type) == 14:
                return 'CNPJ';
            case 'randomKey':
                return 'EVP';
            case 'phoneNumber':
                return 'PHONE';
        }
    }

    /**
     * Gera um CPF válido aleatório
     * @return string
     */
    private function generateValidCpf(): string
    {
        // Gera os 9 primeiros dígitos aleatoriamente
        $cpf = [];
        for ($i = 0; $i < 9; $i++) {
            $cpf[$i] = rand(0, 9);
        }

        // Calcula o primeiro dígito verificador
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += $cpf[$i] * (10 - $i);
        }
        $remainder = $sum % 11;
        $cpf[9] = ($remainder < 2) ? 0 : 11 - $remainder;

        // Calcula o segundo dígito verificador
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $cpf[$i] * (11 - $i);
        }
        $remainder = $sum % 11;
        $cpf[10] = ($remainder < 2) ? 0 : 11 - $remainder;

        // Retorna o CPF formatado como string
        return implode('', $cpf);
    }

}
