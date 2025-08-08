<?php

namespace App\Observers;

use App\Models\User;
use App\Services\PlayFiverService;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $user)
    {
        try {
            // Configurações padrão para rodadas grátis
            $defaultGameCode = config('casino.free_rounds.game_code', 'default_game_code'); // Ex.: configurar em config/casino.php
            $defaultRounds = config('casino.free_rounds.rounds', 10); // Ex.: 10 rodadas

            $dados = [
                'username' => $user->email,
                'game_code' => $defaultGameCode,
                'rounds' => $defaultRounds,
            ];

            // Chama o serviço para conceder rodadas grátis
            $response = PlayFiverService::RoundsFree($dados);

            if ($response['status']) {
                Log::info("Rodadas grátis concedidas com sucesso para o usuário {$user->email}.", $dados);
            } else {
                Log::error("Falha ao conceder rodadas grátis para o usuário {$user->email}: {$response['message']}", $dados);
            }
        } catch (\Exception $e) {
            Log::error("Erro ao conceder rodadas grátis para o usuário {$user->email}: {$e->getMessage()}", $dados);
        }
    }
}