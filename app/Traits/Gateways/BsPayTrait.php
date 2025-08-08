<?php

namespace App\Traits\Gateways;

use App\Models\AffiliateHistory;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewDepositNotification;
use App\Helpers\Core as Helper;

trait BsPayTrait
{
    protected static string $uri;
    protected static string $clienteId;
    protected static string $clienteSecret;
    protected static string $statusCode;
    protected static string $errorBody;

    private static function generateCredentials()
    {
        $setting = Gateway::first();

        if (!empty($setting)) {
            self::$uri = $setting->bspay_uri;
            self::$clienteId = $setting->bspay_cliente_id;
            self::$clienteSecret = $setting->bspay_cliente_secret;

            return self::authentication();
        }

        return false;
    }

    private static function authentication()
    {
        $client_id      = self::$clienteId;
        $client_secret  = self::$clienteSecret;
        $credentials = base64_encode($client_id . ":" . $client_secret);

        \Log::debug(self::$uri);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post(self::$uri . 'oauth/token', [
            'grant_type' => 'client_credentials',
        ]);

        \Log::debug("response: " . $response);

        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token'];
        } else {
            self::$statusCode = $response->status();
            self::$errorBody = $response->body();
            return false;
        }
    }

    /**
     * Request QRCODE
     * Metodo para solicitar uma QRCODE PIX
     */
 public static function requestQrcode($request)
{
    if ($access_token = self::generateCredentials()) {

        $setting = Helper::getSetting();
        $rules = [
            'amount' => ['required', 'numeric', 'min:' . $setting->min_deposit, 'max:' . $setting->max_deposit],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // CPF padrão (um CPF válido!)
        $defaultCpf = '12345678909'; // Substitua por um CPF válido autorizado na sua conta BSPay

        $parameters = [
            'amount' => Helper::amountPrepare($request->amount),
            "external_id" => auth('api')->user()->id,
            "payerQuestion" => "Pagamento referente ao serviço/produto X",
            "postbackUrl" => url('/bspay/callback'),
            "payer" => [
                "name" => auth('api')->user()->name,
                "document" => $defaultCpf,
                "email" => auth('api')->user()->email
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $access_token,
            'Content-Type' => 'application/json',
        ])->post(self::$uri . 'pix/qrcode', $parameters);

        if ($response->successful()) {
            $responseData = $response->json();

            self::generateTransaction($responseData['transactionId'], Helper::amountPrepare($request->amount));
            self::generateDeposit($responseData['transactionId'], Helper::amountPrepare($request->amount));

            return [
                'status' => true,
                'idTransaction' => $responseData['transactionId'],
                'qrcode' => $responseData['qrcode']
            ];
        } else {
            self::$statusCode = $response->status();
            self::$errorBody = $response->body();
            return response()->json(['error' => $response->body()], 400);
        }
    }
}

    private static function generateDeposit($idTransaction, $amount)
    {
        $userId = auth('api')->user()->id;
        $wallet = Wallet::where('user_id', $userId)->first();

        Deposit::create([
            'payment_id'=> $idTransaction,
            'user_id'   => auth('api')->user()->id,
            'amount'    => $amount,
            'type'      => 'pix',
            'currency'  => $wallet->currency,
            'symbol'    => $wallet->symbol,
            'status'    => 0
        ]);
    }

    private static function generateTransaction($idTransaction, $amount)
    {
        $setting = \Helper::getSetting();

        Transaction::create([
            'payment_id' => $idTransaction,
            'user_id' => auth('api')->user()->id,
            'payment_method' => 'pix',
            'price' => $amount,
            'currency' => $setting->currency_code,
            'status' => 0
        ]);
    }

    public static function consultStatusTransaction($request)
    {
        $transaction = Transaction::where('payment_id', $request->idTransaction)->where('status', 1)->first();
        if (!empty($transaction)) {
            self::FinishTransaction($transaction->price, $transaction->user_id);
            return response()->json(['status' => 'PAID']);
        }

        return response()->json(['status' => false], 400);
    }

    public static function finalizePayment($idTransaction): bool
    {
        $transaction = Transaction::where('payment_id', $idTransaction)->where('status', 0)->first();
        $setting = Helper::getSetting();

        if (!empty($transaction)) {
            $user = User::find($transaction->user_id);

            $wallet = Wallet::where('user_id', $transaction->user_id)->first();
            if (!empty($wallet)) {

                // verifica se é o primeiro deposito, verifica as transações, somente se for transações concluidas
                $checkTransactions = Transaction::where('user_id', $transaction->user_id)
                    ->where('status', 1)
                    ->count();

                if ($checkTransactions == 0 || empty($checkTransactions)) {
                    if ($transaction->accept_bonus) {
                        // pagar o bonus
                        $bonus = Helper::porcentagem_xn($setting->initial_bonus, $transaction->price);
                        $wallet->increment('balance_bonus', $bonus);

                        if (!$setting->disable_rollover) {
                            $wallet->update(['balance_bonus_rollover' => $bonus * $setting->rollover]);
                        }
                    }
                }

                // rollover deposito
                if ($setting->disable_rollover == false) {
                    $wallet->increment('balance_deposit_rollover', ($transaction->price * intval($setting->rollover_deposit)));
                }

                // acumular bonus
                Helper::payBonusVip($wallet, $transaction->price);

                // quando tiver desativado o rollover, ele manda o dinheiro depositado direto pra carteira de saque
                if ($setting->disable_rollover) {
                    $wallet->increment('balance_withdrawal', $transaction->price); // carteira de saque
                } else {
                    $wallet->increment('balance', $transaction->price); // carteira de jogos, não permite sacar
                }

                if ($transaction->update(['status' => 1])) {
                    $deposit = Deposit::where('payment_id', $idTransaction)->where('status', 0)->first();
                    if (!empty($deposit)) {

                        // fazer o deposito em cpa
                        $affHistoryCPA = AffiliateHistory::where('user_id', $user->id)
                            ->where('commission_type', 'cpa')
                            ->first();

                        \Log::info(json_encode($affHistoryCPA));
                        if (!empty($affHistoryCPA)) {
                            // faz uma soma de depositos feitos pelo indicado
                            $affHistoryCPA->increment('deposited_amount', $transaction->price);

                            // verifcia se já pode receber o cpa
                            $sponsorCpa = User::find($user->inviter);

                            \Log::info(json_encode($sponsorCpa));
                            // verifica se foi pago ou não
                            if (!empty($sponsorCpa) && $affHistoryCPA->status == 'pendente') {
                                \Log::info('Deposited Amount: ' . $affHistoryCPA->deposited_amount);
                                \Log::info('Affiliate Baseline: ' . $sponsorCpa->affiliate_baseline);
                                \Log::info('Amount: ' . $deposit->amount);

                                if ($affHistoryCPA->deposited_amount >= $sponsorCpa->affiliate_percentage_baseline || $deposit->amount >= $sponsorCpa->affiliate_percentage_baseline) {
                                    // paga a % do valor depositado
                                    $commissionPercentage = ($transaction->price * $sponsorCpa->affiliate_percentage_cpa) / 100;
                                    $walletCpa = Wallet::where('user_id', $affHistoryCPA->inviter)->first();
                                    if (!empty($walletCpa)) {
                                        $walletCpa->increment('refer_rewards', $commissionPercentage); // coloca a comissão
                                        $affHistoryCPA->update(['status' => 1, 'commission_paid' => $commissionPercentage]); // desativa cpa
                                    }
                                } else if ($affHistoryCPA->deposited_amount >= $sponsorCpa->affiliate_baseline || $deposit->amount >= $sponsorCpa->affiliate_baseline) {
                                    // paga o valor de CPA
                                    $walletCpa = Wallet::where('user_id', $affHistoryCPA->inviter)->first();
                                    if (!empty($walletCpa)) {
                                        $walletCpa->increment('refer_rewards', $sponsorCpa->affiliate_cpa); // coloca a comissão
                                        $affHistoryCPA->update(['status' => 1, 'commission_paid' => $sponsorCpa->affiliate_cpa]); // desativa cpa
                                    }
                                }
                            }
                        }

                        if ($deposit->update(['status' => 1])) {
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

    public static function FinishTransaction($price, $userId)
    {
        $setting = Setting::first();
        $wallet = Wallet::where('user_id', $userId)->first();
        if (!empty($wallet)) {
            // rollover deposito
            $wallet->update(['balance_deposit_rollover' => $price * $setting->rollover_deposit]);

            // acumular bonus
            \Helper::payBonusVip($wallet, $price);
        }
    }

    public static function MakePayment(array $array)
    {

        if ($access_token = self::generateCredentials()) {

            $pixKey     = $array['pix_key'];
            $pixType    = self::FormatPixType($array['pix_type']);
            $amount     = $array['amount'];
            //$doc        = \Helper::soNumero($array['document']); // NÃO USA MAIS

            $parameters = [
                'amount' => floatval(\Helper::amountPrepare($amount)),
                "external_id" => $array['payment_id'],
                "payerQuestion" => "Fazendo pagamento.",
                "payer" => [
                    "key" => $pixKey,
                    "keyType" => $pixType,
                    //"document" => $doc // NÃO ENVIA MAIS
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ])->post(self::$uri . 'payment/pix/send', $parameters);

            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['status'] === 'PROCESSING') {
                    $withdrawal = Withdrawal::find($array['payment_id']);
                    if (!empty($withdrawal)) {
                        $deposit = Deposit::where('payment_id',  $responseData['transactionId'])->first();
                        if (!empty($deposit)) {
                            $deposit->update(['status' => 1]);
                        }

                        $withdrawal->update([
                            'proof' => $responseData['transactionId'],
                            'status' => 1,
                        ]);
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

    private static function FormatPixType($type)
    {
        switch ($type) {
            case 'email':
                return 'EMAIL';
            case 'document':
                return 'CPF';
            case 'randomKey':
                return 'ALEATORIA';
            case 'phoneNumber':
                return 'TELEFONE';
        }
    }
}
