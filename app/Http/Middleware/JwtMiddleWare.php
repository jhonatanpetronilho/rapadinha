<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT; // Se você estiver usando firebase/php-jwt
use Firebase\JWT\Key;
use App\Models\User;

class JwtMiddleWare
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = null;
        $authHeader = $request->header('Authorization');

        // Pega o token do header Authorization: Bearer TOKEN
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (!$token) {
            return response()->json(['error' => 'Token não informado'], 401);
        }

        try {
            // Use a sua secret do JWT!
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET', 'suachavesecreta'), 'HS256'));

            // Aqui depende do seu payload! Supondo sub = id do usuário:
            $userId = $decoded->sub ?? null;
            if (!$userId) {
                return response()->json(['error' => 'Token inválido'], 401);
            }

            $user = User::find($userId);
            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado'], 401);
            }

            // Setar o user autenticado no Laravel para toda a request
            auth()->login($user);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Token inválido', 'message' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
