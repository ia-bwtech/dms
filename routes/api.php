<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OddsController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\HandicapperController;
use App\Http\Controllers\SportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/odds', [OddsController::class, 'index']);
Route::get('/odds/local', [OddsController::class, 'localOdds']);
Route::post('/bet', [BetController::class, 'store']);
Route::get('/stats/{id}', [UserController::class, 'stats']);
Route::get('/leagues', [LeagueController::class, 'index']);
Route::get('/leaderboard/{leagueName}/{sportName}/{date}/{sortBy?}', [HandicapperController::class, 'leaderboardApi']);
Route::get('/leaderboard/search', [HandicapperController::class, 'leaderboardSearch']);
Route::post('/verified/status', [UserController::class, 'changeVerifiedStatus']);
Route::get('/filters', [SportController::class, 'index']);
Route::get('/bet-check', [BetController::class, 'test']);
Route::get('/net-units/{id}', [UserController::class, 'units']);
Route::get('/net-units-sports/{id}', [UserController::class, 'sportsUnits']);
Route::get('/pending-bets', [BetController::class, 'pendingBets']);

//blind Records
Route::get('/blind/records/{leagueName}/{sportName}', [HandicapperController::class, 'blindRecords']);
Route::get('/leaderboard/search', [HandicapperController::class, 'leaderboardSearch']);

Route::get('/top-sports/{leagueName}/{sportName}/{date}', [HandicapperController::class, 'topSportsCappers']);
