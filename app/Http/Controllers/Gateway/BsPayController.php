<?php



namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Traits\Affiliates\AffiliateHistoryTrait;
use App\Traits\Gateways\BsPayTrait;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use App\Helpers\Core as Helper;
use App\Models\AffiliateWithdraw;

class BsPayController extends Controller
{
    use BsPayTrait, AffiliateHistoryTrait;


    /**
     * @dev victormsalatiel
     * @param Request $request
     * @return null
     */
    public function getQRCodePix(Request $request)
    {
        return self::requestQrcode($request);
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function callbackMethod(Request $request)
    {
        $data = $request->requestBody;

        ///\DB::table('debug')->insert(['text' => json_encode($request->all())]);

        if (isset($data['transactionId']) && $data['transactionType'] == 'RECEIVEPIX') {
            if ($data['status'] == "PAID") {
                if (self::finalizePayment($data['transactionId'])) {
                    return response()->json([], 200);
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     * @dev victormsalatiel
     */
    public function consultStatusTransactionPix(Request $request)
    {

        return self::consultStatusTransaction($request);
    }

    /**
     * Display the specified resource.
     * @dev victormsalatiel
     */
    public function withdrawalFromModal($id)
    {
        $withdrawal = Withdrawal::find($id);
        if (!empty($withdrawal)) {
            $parm = [
                'pix_key'           => $withdrawal->pix_key,
                'pix_type'          => $withdrawal->pix_type,
                'amount'            => $withdrawal->amount,
                'document'          => $withdrawal->document,
                'payment_id'        => $withdrawal->id
            ];

            $resp = self::MakePayment($parm);

            if ($resp) {
                $withdrawal->update(['status' => 1]);
                Notification::make()
                    ->title('Saque solicitado')
                    ->body('Saque solicitado com sucesso')
                    ->success()
                    ->send();

                return back();
            } else {
                Notification::make()
                    ->title('Erro no saque')
                    ->body('Erro ao solicitar o saque')
                    ->danger()
                    ->send();

                return back();
            }
        }
    }

     /**
     * Script modificado por Telegram: @thigasdev
     * Fuja de Golpistas!
     */
    public function cancelWithdrawalFromModal($id, $action)
    {
        if($action == 'user') {
            return $this->cancelWithdrawalUser($id);
        }

        if($action == 'affiliate') {
            return $this->cancelWithdrawalAffiliate($id);
        }
    }

    /**
     * Script modificado por Telegram: @thigasdev
     * Fuja de Golpistas!
     */
    private function cancelWithdrawalAffiliate($id)
    {
        $withdrawal = AffiliateWithdraw::find($id);
        if(!empty($withdrawal)) {
            $wallet = Wallet::where('user_id', $withdrawal->user_id)
                ->where('currency', $withdrawal->currency)
                ->first();

            if(!empty($wallet)) {
                $wallet->increment('refer_rewards', $withdrawal->amount);

                $withdrawal->update(['status' => 2]);
                Notification::make()
                    ->title('Saque cancelado')
                    ->body('Saque cancelado com sucesso')
                    ->success()
                    ->send();

                return back();
            }
            return back();
        }
        return back();
    }

    /**
     * Script modificado por Telegram: @thigasdev
     * Fuja de Golpistas!
     */
    private function cancelWithdrawalUser($id)
    {
        $withdrawal = Withdrawal::find($id);
        if(!empty($withdrawal)) {
            $wallet = Wallet::where('user_id', $withdrawal->user_id)
                ->where('currency', $withdrawal->currency)
                ->first();

            if(!empty($wallet)) {
                $wallet->increment('balance_withdrawal', $withdrawal->amount);

                $withdrawal->update(['status' => 2]);
                Notification::make()
                    ->title('Saque cancelado')
                    ->body('Saque cancelado com sucesso')
                    ->success()
                    ->send();

                return back();
            }
            return back();
        }
        return back();
    }
}