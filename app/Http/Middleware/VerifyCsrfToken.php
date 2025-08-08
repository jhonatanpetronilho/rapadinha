<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'api/bspay/consult-status-transaction',
        'api/digitopay/consult-status-transaction',
        'api/suitpay/consult-status-transaction',
        'digitopay/*',
        'slotegrator/*',
        'suitpay/*',
        'bspay/',
        'bspay/*',
        'vgames/*',
        'webhooks/*',
        'drakon_api',
        'drakon_api/*',
         'playfiver/*', // <--- Adicione essa linha
        'salsa/*',
        'bspay/*',
        'gold_api',
        'gold_api/*',
        'kagaming/*',
        'vibra/*',
        'cron/*',
         'cron/playconnect',
        'venix_api',
        'venix_api/*',
        'ever/*',
        'ever',
        'pgclone',
        'pgclone/*',
        'tbs',
        'tbs/*',
        'voxelgator',
        'voxelgator/*',
        'mercadopago/*',
        'mercadopago'
    ];
}