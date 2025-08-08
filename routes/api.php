<?php

use App\Http\Controllers\Api\Profile\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ScratchCard;
use App\Models\Wallet;
use App\Models\ScratchCardPlay;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//==========================================================================
// ROTAS DAS RASPADINHAS
//==========================================================================

// Lista todas as raspadinhas ativas para a página inicial
Route::get('/scratch/cards', function() {
    return ScratchCard::where('active', true)->get();
});

// Busca os dados completos de uma raspadinha específica, incluindo seus prêmios
Route::get('/scratch/card/{id}', function($id) {
    return App\Models\ScratchCard::with('prizes')->findOrFail($id);
});

// Rota principal de sorteio da raspadinha
Route::middleware('auth:api')->post('/scratch/draw/{id}', function(Request $request, $id) {
    
    //-----------------------------------------------------
    // PARTE 1: Validação e Débito do Saldo
    //-----------------------------------------------------
    $user = auth()->user();
    $scratch = \App\Models\ScratchCard::with('prizes')->findOrFail($id);

    $wallet = \App\Models\Wallet::where('user_id', $user->id)->where('active', 1)->first();
    if (!$wallet) {
        return response()->json(['error' => 'Carteira não encontrada!'], 404);
    }
    if ($wallet->balance < $scratch->price) {
        return response()->json(['error' => 'Saldo insuficiente para jogar!'], 403);
    }
    $wallet->balance -= $scratch->price;
    $wallet->save();

    $prizes = $scratch->prizes->values();
    if ($prizes->count() < 3) {
        return response()->json(['error' => 'Cadastre pelo menos 3 prêmios para esta raspadinha!'], 400);
    }

    //-----------------------------------------------------
    // PARTE 2: Lógica de Sorteio do Prêmio
    //-----------------------------------------------------

    // 2.1 - Categoriza todos os prêmios em "baldes"
    $categorizedPrizes = [
        'null' => [(object)['name' => 'Nenhum', 'value' => 0, 'image' => null]],
        'low_up_to_3' => [],
        'medium_low_up_to_10' => [],
        'medium_up_to_2000' => [],
        'high_above_2000' => []
    ];

    foreach ($prizes as $prize) {
        $value = (float)$prize->value;
        if ($value > 0 && $value <= 3) {
            $categorizedPrizes['low_up_to_3'][] = $prize;
        } elseif ($value > 3 && $value <= 10) {
            $categorizedPrizes['medium_low_up_to_10'][] = $prize;
        } elseif ($value > 10 && $value <= 2000) {
            $categorizedPrizes['medium_up_to_2000'][] = $prize;
        } elseif ($value > 2000) {
            $categorizedPrizes['high_above_2000'][] = $prize;
        }
    }

    // 2.2 - Sorteia uma CATEGORIA com base no RTP
    function selectPrizeCategory($rtp) {
        $rand = mt_rand(1, 100);

        // FAIXA 1: RTP ATÉ 49
        if ($rtp <= 49) {
            if ($rand <= 85) { return 'null'; } 
            else { return 'low_up_to_3'; }
        } 
        // FAIXA 2: RTP DE 50 a 81
        elseif ($rtp <= 81) {
            if ($rand <= 55) { return 'null'; } 
            elseif ($rand <= 90) { return 'low_up_to_3'; } 
            else { return 'medium_low_up_to_10'; }
        } 
        // FAIXA 3: RTP DE 82 a 100
        else {
            if ($rand <= 20) { return 'null'; } 
            elseif ($rand <= 60) { return 'low_up_to_3'; } 
            elseif ($rand <= 90) { return 'medium_up_to_2000'; } 
            else { return 'high_above_2000'; }
        }
    }

    // 2.3 - Sorteia um PRÊMIO dentro da categoria sorteada
    function selectPrizeWithinCategory($categoryPrizes, $category) {
        if (empty($categoryPrizes)) {
            return (object)['name' => 'Nenhum', 'value' => 0, 'image' => null];
        }
        if ($category === 'low_up_to_3') {
            $weightedPrizes = [];
            foreach ($categoryPrizes as $prize) {
                $weight = 1.0;
                if ((float)$prize->value >= 2) { $weight = 0.3; }
                for ($i = 0; $i < $weight * 10; $i++) { $weightedPrizes[] = $prize; }
            }
            if (empty($weightedPrizes)) return $categoryPrizes[array_rand($categoryPrizes)];
            return $weightedPrizes[array_rand($weightedPrizes)];
        } else {
            return $categoryPrizes[array_rand($categoryPrizes)];
        }
    }

    // 2.4 - Executa o sorteio e define o prêmio final
    $selectedCategory = selectPrizeCategory($scratch->rtp);
    $finalPrize = null;
    $win = false;

    if ($selectedCategory === 'null') {
        $win = false;
        $finalPrize = (object)['name' => 'Nenhum', 'value' => 0, 'image' => null];
    } else {
        $availablePrizes = $categorizedPrizes[$selectedCategory];
        if (!empty($availablePrizes)) {
            $finalPrize = selectPrizeWithinCategory($availablePrizes, $selectedCategory);
            $win = true;
            
            $wallet->balance += $finalPrize->value;
            $wallet->save();
        } else {
            $win = false;
            $finalPrize = (object)['name' => 'Nenhum', 'value' => 0, 'image' => null];
        }
    }

    //-----------------------------------------------------
    // PARTE 3: Salva a Jogada e Monta o Grid Visual
    //-----------------------------------------------------
    ScratchCardPlay::create([
        'user_id' => $user->id,
        'scratch_card_id' => $scratch->id,
        'cards' => json_encode([]),
        'win' => $win,
        'prize' => $finalPrize->value,
    ]);

    $cards = [];
    if ($win && $finalPrize) {
        for ($i = 0; $i < 3; $i++) {
            $cards[] = ['name' => $finalPrize->name, 'value' => $finalPrize->value, 'image' => $finalPrize->image ? url('storage/' . $finalPrize->image) : null, 'revealed' => false,];
        }
        $fakes = $prizes->filter(fn($p) => $p->id !== $finalPrize->id)->shuffle();
        $fakeArr = [];
        while (count($fakeArr) < 6) {
            if ($fakes->isEmpty()) break;
            foreach ($fakes as $fp) {
                $count = collect($fakeArr)->where('name', $fp->name)->count();
                if ($count < 2) {
                    $fakeArr[] = ['name' => $fp->name, 'value' => $fp->value, 'image' => $fp->image ? url('storage/' . $fp->image) : null, 'revealed' => false];
                    if (count($fakeArr) == 6) break;
                }
            }
        }
        $cards = array_merge($cards, $fakeArr);
    } else {
        $shuffled = $prizes->shuffle();
        $fakeArr = [];
        while (count($fakeArr) < 9) {
            if ($shuffled->isEmpty()) break;
            foreach ($shuffled as $fp) {
                $count = collect($fakeArr)->where('name', $fp->name)->count();
                if ($count < 2) {
                    $fakeArr[] = ['name' => $fp->name, 'value' => $fp->value, 'image' => $fp->image ? url('storage/' . $fp->image) : null, 'revealed' => false];
                    if (count($fakeArr) == 9) break;
                }
            }
        }
        $cards = $fakeArr;
    }

    shuffle($cards);

    return response()->json([
        'cards' => $cards,
        'win' => $win,
        'prize' => [ 'value' => $finalPrize->value, 'name'  => $finalPrize->name, ]
    ]);
});

//==========================================================================
// OUTRAS ROTAS DA APLICAÇÃO (INTACTAS)
//==========================================================================

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () { include_once(__DIR__ . '/groups/api/auth/auth.php'); });

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::prefix('profile')->group(function () {
            include_once(__DIR__ . '/groups/api/profile/profile.php');
            include_once(__DIR__ . '/groups/api/profile/affiliates.php');
            include_once(__DIR__ . '/groups/api/profile/wallet.php');
            include_once(__DIR__ . '/groups/api/profile/likes.php');
            include_once(__DIR__ . '/groups/api/profile/favorites.php');
            include_once(__DIR__ . '/groups/api/profile/recents.php');
            include_once(__DIR__ . '/groups/api/profile/vip.php');
        });
    Route::prefix('wallet')->group(function () {
            include_once(__DIR__ . '/groups/api/wallet/deposit.php');
            include_once(__DIR__ . '/groups/api/wallet/withdraw.php');
        });
    include_once(__DIR__ . '/groups/api/missions/mission.php');
    include_once(__DIR__ . '/groups/api/missions/missionuser.php');
});

Route::prefix('categories')->group(function () { include_once(__DIR__ . '/groups/api/categories/index.php'); });
include_once(__DIR__ . '/groups/api/games/index.php');
include_once(__DIR__ . '/groups/api/gateways/digitopay.php');
include_once(__DIR__ . '/groups/api/gateways/suitpay.php');
include_once(__DIR__ . '/groups/api/gateways/bspay.php');
Route::prefix('search')->group(function () { include_once(__DIR__ . '/groups/api/search/search.php'); });
Route::prefix('profile')->group(function () {
    Route::post('/getLanguage', [ProfileController::class, 'getLanguage']);
    Route::put('/updateLanguage', [ProfileController::class, 'updateLanguage']);
});
Route::prefix('providers')->group(function () { });
Route::prefix('settings')->group(function () {
    include_once(__DIR__ . '/groups/api/settings/settings.php');
    include_once(__DIR__ . '/groups/api/settings/banners.php');
    include_once(__DIR__ . '/groups/api/settings/currency.php');
    include_once(__DIR__ . '/groups/api/settings/bonus.php');
});
Route::prefix('spin')->group(function () {
    include_once(__DIR__ . '/groups/api/spin/index.php');
})->name('landing.spin.');