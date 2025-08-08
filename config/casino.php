<?php

return [
    'free_rounds' => [
        'game_code' => env('FREE_ROUNDS_GAME_CODE', 'default_game_code'), // Ex.: 'slot123'
        'rounds' => env('FREE_ROUNDS_QUANTITY', 10), // Quantidade padrão de rodadas
    ],
];