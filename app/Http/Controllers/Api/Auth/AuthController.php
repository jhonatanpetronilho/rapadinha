<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\SpinRuns;
use App\Models\Setting;
use App\Models\Wallet;
use App\Traits\Affiliates\AffiliateHistoryTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use GuzzleHttp\Client; // Importação da classe GuzzleHttp Client

use App\Http\Controllers\Integrations\AresSMSService;

class AuthController extends Controller
{
    use AffiliateHistoryTrait;

    /*** Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.jwt', ['except' => ['login', 'register', 'submitForgetPassword', 'submitResetPassword']]);
    }


      /**
     * Consulta o nome pelo CPF usando a API externa.
     *
     * @param string $cpf
     * @return string|null Retorna o nome ou null em caso de falha.
     */
    // private function consultarNomePorCpf($cpf)
    // {
    //     $token = '155841505TrNbXpsgxl281367112';
    //     $url = "https://ws.hubdodesenvolvedor.com.br/v2/nome_cpf/?cpf={$cpf}&token={$token}";

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     $data = json_decode($response, true);

    //     if ($data && isset($data['status']) && $data['status'] === true && isset($data['result']['nome'])) {
    //         return $data['result']['nome'];
    //     }

    //     return null;
    // }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /*** @return \Illuminate\Http\JsonResponse
     */
    public function verify()
    {
        return response()->json(auth('api')->user());
    }

    /*** Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try {
            $credentials = request(['email', 'password']);

            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => trans('Check credentials')], 400);
            }

            return $this->respondWithToken($token);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token'
            ], 400);
        }
    }

    /*** Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
       \Log::info('==== DEBUG REGISTER REQUEST ===='); // para facilitar busca no log
    \Log::info($request->all());
        try {
            $setting = \Helper::getSetting();

            $rules = [
                //'cpf'           => 'required|string|cpf|unique:users',  // CPF validado aqui
                'phone'         => 'required|string|unique:users',
                'email'         => 'required|email|unique:users',
                'name'          => 'required|string',
                'password'      => ['required', Rules\Password::min(6)],
                // 'term_a'        => 'required',
                // 'agreement'     => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $userData = $request->only(['name', 'password', 'email', 'phone']);
            //$userData['name'] = $nome;  // Usar o nome obtido pela API
            $userData['phone'] = \Helper::soNumero($userData['phone']);

            /// criando dados do afiliado
            $userData['affiliate_revenue_share']    = $setting->revshare_percentage ;
            $userData['affiliate_cpa']              = $setting->cpa_value;
            $userData['affiliate_baseline']         = $setting->cpa_baseline;

            if($user = User::create($userData))
            {
                // >>> ADICIONADO: Envio do evento CompleteRegistration para a API de Conversões do Facebook
                \Log::info('--- DEBUG AuthController: User created. Attempting to send CompleteRegistration to CAPI.'); // DEBUG
                $this->sendFacebookConversionApiEvent('CompleteRegistration', $user);
                \Log::info('--- DEBUG AuthController: sendFacebookConversionApiEvent called.'); // DEBUG
                // <<< FIM DA ADIÇÃO >>>

                // ----    Send SMS/WHATSAPP    ----
                // $payload = [
                //     "cpf" => !empty($userData['cpf']) ? $userData['cpf'] : null,
                //     "name" => !empty($userData['name']) ? $userData['name'] : null,
                //     "email" => !empty($userData['email']) ? $userData['email'] : null,
                //     "type" => 'new',
                //     "event_identify" => 'Novo Cadastro',
                //     "phone" => !empty($userData['phone']) ? $userData['phone'] : null,
                //     "username" => !empty($userData['username']) ? $userData['username'] : null,
                //     "checkout" => !empty($userData['checkout']) ? $userData['checkout'] : null,
                //     "value" => !empty($userData['value']) ? $userData['value'] : null
                // ];
                // AresSMSService::sendSMS($payload);
                // ----    Send SMS/WHATSAPP    ----
                if(isset($request->reference_code) && !empty($request->reference_code)) {
    // P20TUKHVRV
    $checkAffiliate = User::where('inviter_code', $request->reference_code)->first();
    \Log::info('DEBUG - Procurando afiliador', [
        'reference_code' => $request->reference_code,
        'afiliador_encontrado' => $checkAffiliate ? $checkAffiliate->id : null,
    ]);
    if(!empty($checkAffiliate)) {
        if($checkAffiliate) {
            \Log::info('DEBUG - Antes de update inviter', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'inviter_antes' => $user->inviter,
                'affiliate_id' => $checkAffiliate->id,
            ]);

            $result = $user->update(['inviter' => $checkAffiliate->id]);
            $user->refresh();

            \Log::info('DEBUG - Depois do update inviter', [
                'user_id' => $user->id,
                'inviter_depois' => $user->inviter,
                'update_result' => $result,
            ]);

            self::saveAffiliateHistory($user);
        }
    }
}


                // >>> TRATAMENTO PARA RODADAS GRÁTIS: AGORA, APENAS LOGA O ERRO E NÃO INTERROMPE O FLUXO <<<
                if( $setting->disable_spin) {
                    if(!empty($request->spin_token)) {
                        try {
                            $str = base64_decode($request->spin_token);
                            $obj = json_decode($str);

                            $spin_run = SpinRuns::where([
                                'key'   => $obj->signature,
                                'nonce' => $obj->nonce
                            ])->first();

                            $data = $spin_run->prize;
                            $obj = json_decode($data);
                            $value = $obj->value;

                            Wallet::where('user_id', $user->id)->increment('balance_bonus', $value);

                        } catch (\Exception $e) {
                            // !!! IMPORTANTE: APENAS LOGA O ERRO E CONTINUA O FLUXO DO REGISTRO !!!
                            \Log::error('Erro ao conceder rodadas grátis para o usuário ' . ($user->email ?? 'N/A') . ': ' . $e->getMessage());
                            // O frontend não receberá um erro 400 por causa disso.
                        }
                    }
                }
                // <<< FIM DO TRATAMENTO DE RODADAS GRÁTIS >>>

                $credentials = $request->only(['email', 'password']);
                $token = auth('api')->attempt($credentials);
                if (!$token) {
                    // Se o login JWT falhar AQUI (por algum motivo, após o registro bem-sucedido),
                    // ele retornará 'Unauthorized'. O frontend deve lidar com isso.
                    \Log::error('Erro ao tentar logar automaticamente após o registro para o usuário: ' . $request->email);
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                return $this->respondWithToken($token); // Retorna o token JWT e os dados do usuário para o frontend
            }

        } catch (\Exception $e) {
            // Este catch pega erros gerais no método register.
            \Log::error('Erro geral no método register: ' . $e->getMessage() . ' no arquivo ' . $e->getFile() . ' na linha ' . $e->getLine());
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /*** Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /*** Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /*** Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }


    /*** @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitForgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(5);

        $psr = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        if(!empty($psr)) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        }

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        \Mail::send('emails.forget-password', [ 'token' => $token, 'resetLink' => url('/reset-password/'.$token) ], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['status' => true, 'message' => 'We have e-mailed your password reset link!'], 200);
    }

    /*** @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitResetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
                'token' => 'required',
            ]);

            $checkToken = DB::table('password_reset_tokens')->where('token', $request->token)->first();
            if(!empty($checkToken)) {
                $user = User::where('email', $request->email)->first();
                if(!empty($user)) {
                    if($user->update(['password' => $request->password])) {
                        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
                        return response()->json(['status' => true, 'message' => 'Your password has been changed!'], 200);
                    }else{
                        return response()->json(['error' => 'Erro ao atualizar senha'], 400);
                    }
                }else{
                    return response()->json(['error' => 'Email não é valido!'], 400);
                }
            }

            return response()->json(['error' => 'Token não é valido!'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /*** Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('api')->user(),
            'expires_in' => time() + 1
            //'expires_in' => auth('api')->factory()->getTTL() * 6000000
        ]);
    }

    // ADICIONADO: Novo método para enviar eventos à API de Conversões do Facebook
    /**
     * Envia um evento para a API de Conversões do Facebook.
     * @param string $eventName Nome do evento (ex: 'CompleteRegistration').
     * @param \App\Models\User $user Objeto do usuário recém-registrado.
     * @return void
     */
    private function sendFacebookConversionApiEvent(string $eventName, \App\Models\User $user)
    {
        \Log::info('--- DEBUG sendFacebookConversionApiEvent: Method entered.'); // DEBUG

        // 1. Obtém o ID do Pixel e o Token da API de Conversões do arquivo .env
        $pixelId = env('FACEBOOK_PIXEL_ID');
        $accessToken = env('FACEBOOK_CONVERSIONS_API_TOKEN');

        \Log::info('--- DEBUG sendFacebookConversionApiEvent: Pixel ID: ' . $pixelId . ', Access Token (first 5 chars): ' . substr($accessToken, 0, 5)); // DEBUG

        // Se as credenciais não estiverem configuradas no .env, não tenta enviar o evento e loga um aviso.
        if (empty($pixelId) || empty($accessToken)) {
            \Log::warning('--- DEBUG sendFacebookConversionApiEvent: Pixel ID or Conversions API Token empty. Event NOT sent.'); // DEBUG
            return;
        }

        $client = new Client(); // Cria uma nova instância do Guzzle HTTP Client
        // Define a URL da API de Conversões do Facebook. Usamos a versão 19.0 da API (a mais recente na época).
        $url = "https://graph.facebook.com/v19.0/{$pixelId}/events";

        // Preparar os dados do usuário para enviar ao Facebook.
        // É CRUCIAL HASHEAR (SHA256) os dados sensíveis como email e telefone para privacidade.
        // O Facebook também recomenda converter para minúsculas e remover espaços antes de hashear.

        // <<< CORREÇÃO AQUI para o erro "Only variables should be passed by reference" >>>
        $userEmail = $user->email ?? '';
        $userPhone = \Helper::soNumero($user->phone ?? '');
        $userName = $user->name ?? '';

        $firstName = explode(' ', $userName)[0] ?? '';
        // Garante que end() sempre opere em um array e retorne um valor ou string vazia
        $nameParts = explode(' ', $userName);
        $lastName = (count($nameParts) > 1) ? end($nameParts) : '';


        $userData = [
            // Hasheamento de dados do cliente (sempre minúsculas e sem espaços antes de hashear)
            'em' => hash('sha256', strtolower(trim($userEmail))),
            'ph' => hash('sha256', strtolower(trim($userPhone))),
            'fn' => hash('sha256', strtolower(trim($firstName))),
            'ln' => hash('sha256', strtolower(trim($lastName))),

            // IP e User Agent (enviados diretamente sem hash, o Facebook fará o processamento)
            'fbc' => $_COOKIE['_fbc'] ?? null, // Cookie de clique do Facebook (se existir)
            'fbp' => $_COOKIE['_fbp'] ?? null, // Cookie do navegador do Facebook (se existir)
            'client_ip_address' => request()->ip(), // Endereço IP do usuário
            'client_user_agent' => request()->header('User-Agent'), // User Agent do navegador
        ];
        // <<< FIM DA CORREÇÃO >>>

        // Remove quaisquer valores nulos ou vazios do array para evitar enviar chaves desnecessárias
        $userData = array_filter($userData);
        \Log::info('--- DEBUG sendFacebookConversionApiEvent: User Data (filtered & hashed): ' . json_encode($userData)); // DEBUG

        // Prepara os dados do evento que serão enviados à API de Conversões
        $eventData = [
            [
                'event_name' => $eventName, // Nome do evento (ex: 'CompleteRegistration')
                'event_time' => time(), // Hora atual em timestamp Unix (segundos desde 1970)
                'user_data' => $userData, // Dados hasheadas e não hasheadas do usuário
                'custom_data' => [
                    'currency' => 'BRL', // Moeda da sua plataforma. Ajuste se for diferente.
                    'value' => 0.00, // Valor associado a um registro, se houver (pode ser 0 para registros simples)
                ],
                // A URL de onde o evento foi gerado. url()->previous() tenta pegar a URL anterior.
                'event_source_url' => url()->previous(),
                'action_source' => 'website', // Indica que o evento veio do seu site/servidor
                // Campos opcionais para conformidade com privacidade (LGPD/GDPR no Brasil, GDPR na UE, CCPA nos EUA)
                'data_processing_options' => [],
                'data_processing_options_country' => 0, // 0 para não definido/EUA, 1 para Califórnia (CCPA), 2 para União Europeia (GDPR)
                'data_processing_options_state' => 0, // 0 para não definido, 1000 para Califórnia
                // NÃO ENVIE test_event_code AQUI DENTRO DO ARRAY 'data' - Ele deve ser um parâmetro de nível superior
                // 'test_event_code' => env('FACEBOOK_TEST_EVENT_CODE'), // <<< ESTA LINHA SERÁ REMOVIDA DAQUI >>>
            ]
        ];
        \Log::info('--- DEBUG sendFacebookConversionApiEvent: Event Data Payload: ' . json_encode($eventData)); // DEBUG

        // Carga útil principal para a requisição Guzzle
        $guzzlePayload = [
            'data' => $eventData,
            'access_token' => $accessToken,
        ];

        // Adiciona test_event_code APENAS SE EXISTIR no .env, e no nível CORRETO
        if (env('FACEBOOK_TEST_EVENT_CODE')) {
            $guzzlePayload['test_event_code'] = env('FACEBOOK_TEST_EVENT_CODE');
            \Log::info('--- DEBUG sendFacebookConversionApiEvent: Adding test_event_code to top-level payload.'); // DEBUG
        }


        try {
            \Log::info('--- DEBUG sendFacebookConversionApiEvent: Attempting Guzzle POST request to CAPI.'); // DEBUG
            $response = $client->post($url, [
                'json' => $guzzlePayload // Envia o payload com o test_event_code no nível superior
            ]);

            \Log::info('--- DEBUG sendFacebookConversionApiEvent: Guzzle POST request SUCCESS. Response Body: ' . $response->getBody()->getContents()); // DEBUG

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                \Log::error('--- DEBUG sendFacebookConversionApiEvent: Guzzle Request Error (has response): ' . $responseBody); // DEBUG
            } else {
                \Log::error('--- DEBUG sendFacebookConversionApiEvent: Guzzle Request Error (no response): ' . $e->getMessage()); // DEBUG
            }
        } catch (\Exception $e) {
            \Log::error('--- DEBUG sendFacebookConversionApiEvent: Unexpected Exception: ' . $e->getMessage()); // DEBUG
        }
    }
}