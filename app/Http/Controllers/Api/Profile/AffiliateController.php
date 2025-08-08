<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\AffiliateHistory;
use App\Models\AffiliateWithdraw;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Setting;
use App\Models\Deposit; // Adicionado para poder consultar os depósitos
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mantendo a lógica original que já funciona
        $user           = auth('api')->user()->fresh(); 
        $indications    = User::where('inviter', $user->id)->count();
        $walletDefault  = Wallet::where('user_id', $user->id)->first();

        // ADICIONANDO A NOVA LÓGICA SEM ALTERAR A ORIGINAL
        // 1. Pega os IDs de todos os usuários que o afiliado indicou
        $referredUserIds = User::where('inviter', $user->id)->pluck('id');

        // 2. Calcula o VALOR TOTAL de depósitos GERADOS por esses usuários
        $depositsGenerated = Deposit::whereIn('user_id', $referredUserIds)
                                    ->sum('amount');

        // 3. Calcula o VALOR TOTAL de depósitos PAGOS por esses usuários
        $depositsPaid = Deposit::whereIn('user_id', $referredUserIds)
                               ->where('status', 1) // Apenas depósitos com status PAGO
                               ->sum('amount');

        // Retornando a resposta original + os novos dados
        return response()->json([
            'status'             => true,
            'code'               => $user->inviter_code,
            'url'                => config('app.url') . '/register?code='.$user->inviter_code,
            'indications'        => $indications,
            'wallet'             => $walletDefault,
            'user'               => $user,
            'deposits_generated' => $depositsGenerated, // Novo dado enviado
            'deposits_paid'      => $depositsPaid,      // Novo dado enviado
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function generateCode()
    {
        // NENHUMA ALTERAÇÃO AQUI. CÓDIGO ORIGINAL MANTIDO.
        $code = $this->gencode();
        $setting = \Helper::getSetting();

        if(!empty($code)) {
            $user = auth('api')->user();
            \DB::table('model_has_roles')->updateOrInsert(
                [
                    'role_id' => 2,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ],
            );

            if(auth('api')->user()->update([
                'inviter_code'            => $code,
                'affiliate_revenue_share' => $setting->revshare_percentage,
                'affiliate_cpa'           => $setting->cpa_value,
                'affiliate_baseline'      => $setting->cpa_baseline,
            ])) {
                return response()->json(['status' => true, 'message' => trans('Successfully generated code')]);
            }

            return response()->json(['error' => ''], 400);
        }

        return response()->json(['error' => ''], 400);
    }

    /**
     * @return null
     */
    private function gencode() {
        // NENHUMA ALTERAÇÃO AQUI. CÓDIGO ORIGINAL MANTIDO.
        $code = \Helper::generateCode(10);

        $checkCode = User::where('inviter_code', $code)->first();
        if(empty($checkCode)) {
            return $code;
        }

        return $this->gencode();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function makeRequest(Request $request)
    {
        // NENHUMA ALTERAÇÃO AQUI. CÓDIGO ORIGINAL MANTIDO.
        $settings = Setting::where('id', 1)->first();

        if ($settings) {
            $withdrawalLimit = $settings->withdrawal_limit;
            $withdrawalPeriod = $settings->withdrawal_period;
        } else {
            $withdrawalLimit = null;
            $withdrawalPeriod = null;
        }

        if ($withdrawalLimit !== null && $withdrawalPeriod !== null) {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();

            switch ($withdrawalPeriod) {
                case 'daily':
                    break;
                case 'weekly':
                    $startDate = now()->startOfWeek();
                    $endDate = now()->endOfWeek();
                    break;
                case 'monthly':
                    $startDate = now()->startOfMonth();
                    $endDate = now()->endOfMonth();
                    break;
                case 'yearly':
                    $startDate = now()->startOfYear();
                    $endDate = now()->endOfYear();
                    break;
            }

            $withdrawalCount = AffiliateWithdraw::where('user_id', auth('api')->user()->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            if ($withdrawalCount >= $withdrawalLimit) {
                return response()->json(['message' => 'Você atingiu o limite de saques para este período'], 400);
            }
        }

        $rules = [
            'amount' => ['required', 'numeric', 'min:'.$settings->min_withdrawal, 'max:'.$settings->max_withdrawal],
            'pix_type' => 'required',
        ];

        switch ($request->pix_type) {
            case 'document':
                $rules['pix_key'] = 'required|cpf_ou_cnpj';
                break;
            case 'email':
                $rules['pix_key'] = 'required|email';
                break;
            default:
                $rules['pix_key'] = 'required';
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $comission = auth('api')->user()->wallet->refer_rewards;

        if (floatval($comission) >= floatval($request->amount) && floatval($request->amount) > 0) {
            AffiliateWithdraw::create([
                'user_id'   => auth('api')->id(),
                'amount'    => $request->amount,
                'pix_key'   => $request->pix_key,
                'pix_type'  => $request->pix_type,
                'currency'  => 'BRL',
                'symbol'    => 'R$',
            ]);

            auth('api')->user()->wallet->decrement('refer_rewards', $request->amount);

            return response()->json(['message' => trans('Commission withdrawal successfully carried out')], 200);
        }

        return response()->json(['message' => trans('Commission withdrawal error')], 400);
    }
}
