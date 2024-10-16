<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{PublicApiController,SpinGameApiController,Lucky16GameApiController,Lucky12GameApiController,Timmer36Controller,AndarBaharApiController,TriplechanceApiController};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(PublicApiController::class)->group(function () {
    Route::post('/login', 'Login');
    Route::get('/profile/{id}', 'Profile');
});

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
    
//     // Other protected routes
// });


Route::controller(SpinGameApiController::class)->group(function () {
    Route::get('/spin_result','result_store');
    Route::post('/spin/bet', 'SpinBet');
    Route::get('/spin/bet_history', 'SpinBetHistory');
    Route::get('/spin/result', 'SpinBetResult');
    
});

Route::controller(Lucky12GameApiController::class)->group(function () {
    Route::get('/lucky12_result','lucky12_result_store');
    Route::post('/lucky12/bet', 'lucky12Bet');
    Route::get('/lucky12/bet_history', 'lucky12BetHistory');
    Route::get('/lucky12/result', 'lucky12BetResult');
    
});

Route::controller(Lucky16GameApiController::class)->group(function () {
    Route::get('/lucky16_result','lucky16_result_store');
    Route::post('/lucky16/bet', 'lucky16Bet');
    Route::get('/lucky16/bet_history', 'lucky16BetHistory');
    Route::get('/lucky16/result', 'lucky16BetResult');
    
});

/// Timer 36 Route ////
Route::controller(Timmer36Controller::class)->group(function () {
Route::get('/timmer_36_results','timmer36_result_store');
Route::any('/timer_36_bet', 'timmer36_bet');
Route::get('/timer_36_last_result','timmer36_last13_result');
Route::get('/timer_36_result','timmer36_result_index');
Route::get('/timer_36_bet_history','timmer36_bet_history');
Route::get('/timer_36_win_amount','timmer36_win_amount');
});


//Game Controller//
Route::controller(AndarBaharApiController::class)->group(function () {
Route::post('/andar_bahar/bet', 'bets');
Route::get('/andar_bahar/bet_history', 'bet_history');
Route::get('/andar_bahar/results','results');
Route::get('/cron/{game_id}/','cron');
Route::get('/andar_bahar/insert_random_card','insert_random_card');
});

// Route::controller(AndarbaharApiController::class)->group(function () {
//     Route::get('/andarbahar_result','andarbahar_result_store');
//     Route::post('/andarbahar/bet', 'andarbahar_Bet');
//     Route::get('/andarbahar/bet_history', 'andarbahar_BetHistory');
//     Route::get('/andarbahar/results', 'andarbahar_BetResult');
    
// });

Route::controller(TriplechanceApiController::class)->group(function () {
Route::post('/triple_chance/bet', 'triplechance_bet');
Route::get('/triple_chance/bet_history', 'triplechanceBetHistory');
Route::get('/triple_chance/result', 'triplechanceBetResult');
Route::get('/triple_chance_results','tc_result_store');
});
