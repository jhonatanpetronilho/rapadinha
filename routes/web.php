<?php

use App\Models\Game;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|Sme
*/
Route::middleware(['auth', 'role:admin'])->group(function () { // Proteja a rota para que só admins possam acessar
    Route::get('/admin/users/download-csv', [UserController::class, 'downloadCsv'])->name('admin.users.download-csv');
   
  	Route::resource('admin/scratch-cards', ScratchCardController::class);
});


Route::get('clear', function() {
    Artisan::command('clear', function () {
        Artisan::call('optimize:clear');
       return back();
    });

    return back();
});

// GAMES PROVIDER
include_once(__DIR__ . '/groups/provider/games.php');
include_once(__DIR__ . '/groups/provider/drakon.php');
include_once(__DIR__ . '/groups/provider/playFiver.php');
// include_once(__DIR__ . '/groups/provider/venix.php');
// include_once(__DIR__ . '/groups/provider/salsa.php');


// GATEWAYS
include_once(__DIR__ . '/groups/gateways/digitopay.php');
include_once(__DIR__ . '/groups/gateways/bspay.php');
// include_once(__DIR__ . '/groups/gateways/sharkpay.php');
// include_once(__DIR__ . '/groups/gateways/mercadopago.php');
include_once(__DIR__ . '/groups/gateways/suitpay.php');
/// SOCIAL
include_once(__DIR__ . '/groups/auth/social.php');

// APP
include_once(__DIR__ . '/groups/layouts/app.php');

