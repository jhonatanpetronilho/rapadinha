<?php

namespace App\Http\Middleware;

use Closure;

class BlockByIp
{
    public function handle($request, Closure $next)
    {
        // Lista de IPs permitidos
        $allowedIPs = [
            '172.69.11.240',
            '93.127.212.246',
            '145.223.94.127',
            '189.113.230.63',
            '67.222.158.10',
            '249.209.84.95',
        ];

        // Obtém o endereço IP do cliente
        $clientIP = $request->ip();

        // Verifica se o IP do cliente está na lista de IPs permitidos
        if (!in_array($clientIP, $allowedIPs)) {
            // Retorna uma resposta de erro ou redireciona para outra rota
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Se o IP do cliente estiver na lista de IPs permitidos, passe para o próximo middleware
        return $next($request);
    }
}
