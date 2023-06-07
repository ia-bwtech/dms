<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Models\Odd;
use App\Models\Game;
use App\Models\League;
use Illuminate\Support\Facades\Http;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OddsController extends Controller
{
    public function index() {

        $date = Carbon::createFromFormat('Y-m-d 00:00',  Carbon::today()->format('Y-m-d 00:00'));
        $nextDate = $date->add(2, 'days')->format('Y-m-d 00:00');
        $leagues = League::all();
        // return $leagues;

        foreach($leagues as $league) {

            //Check for NCAAF and NCAAB
            // if($league->name == 'NCAAF') {
            //     $sport = 'football';
            //     $league = 'ncaa';
            // }
            // else if($league->name == 'NCAAB') {
            //     $sport = 'basketball';
            //     $league = 'ncaa';
            // }
            // else {
            //     $sport = $league->sport->name;
            //     $league = $league->name;
            // }

            $allGames = Http::get('https://api-external.oddsjam.com/api/v2/games', [
                'key' => '0483697b-57b6-4787-9bdc-1fc4688bcee7',
                'sport' =>  $league->sport->name,
                'league' => $league->name,
                'start_date_after' => date('Y-m-d' . ' 00:00'),
                'start_date_before' => $nextDate,
                'is_main' => 1
            ]);
            $allGames = json_decode($allGames);

            //Check for any error or missing parameter in the API
            if(!isset($allGames->data)) {
                continue;
            }

            //Check if there are any games in the response
            if(count($allGames->data) == 0) {
                continue;
            }

            foreach($allGames->data as $singleGame) {
                $saveGames = Game::updateOrCreate(
                    ['game_id' => $singleGame->id],
                    [
                    'game_id' => $singleGame->id,
                    'league' => $singleGame->league,
                    'sport' => $singleGame->sport,
                    'home_team' => $singleGame->home_team,
                    'away_team' => $singleGame->away_team,
                    'is_live' => $singleGame->is_live,
                    'start_date' => Carbon::createFromFormat('Y-m-d\TH:i:s+', $singleGame->start_date),
                ]);
            }
        }

        $gamesData = Game::whereBetween('start_date', array(Carbon::today(), $nextDate))->get();
        foreach($gamesData as $singleGame) {
            $odds = Http::get('https://api-external.oddsjam.com/api/v2/game-odds', [
                'key' => '0483697b-57b6-4787-9bdc-1fc4688bcee7',
                'sportsbook' => 'betMGM',
                'game_id' => $singleGame->game_id,
                'is_main' => 1
            ]);

            $odds = json_decode($odds);
            // return $odds->data;
            if(count($odds->data) == 0) {
                // return response()->json(['status' => false, 'message' => 'error', 'odds' => $odds]);
                continue;
            }
            $odds = $odds->data;
            // dd($odds);
            // Log::error(print_r($odds[0]->odds, true));

            //Deleting Old Odds
            $deleteOdds = Odd::where('game_id', $singleGame->game_id)->delete();

            foreach($odds[0]->odds as $key => $odd) {
                // Log::error($key . 'odd: ');
                // Log::error(print_r($odd, true));
                $saveOdds = Odd::Create([
                    'odd_id' => $odd->id,
                    'game_id' => $singleGame->game_id,
                    'name' => $odd->name,
                    'price' => $odd->price,
                    'bet_points' => $odd->bet_points,
                    'market_name' => $odd->market_name,
                    'sports_book_name' => $odd->sports_book_name,
                    'is_live' => $odd->is_live,
                    'is_main' => $odd->is_main,
                    'deep_link_url' => $odd->deep_link_url,
                    'checked_date' => Carbon::createFromFormat('Y-m-d\TH:i:s+', $odd->checked_date),
                ]);
            }
        }
        Log::info('Successfully fetched odds at ' . date('Y-m-d H:i:s A'));

        return 'done';
    }

    public function localOdds(Request $request) {
        // Check for NCAAF and NCAAB
        if($request->league == 'NCAAF') {
            $sport = 'football';
            $league = 'NCAAF';
        }
        else if($request->league == 'NCAAB') {
            $sport = 'basketball';
            $league = 'NCAAB';
        }
        else {
            $sport = $request->sport;
            $league = $request->league;
        }

        $data = Game::whereDate('start_date', $request->date)->where('league', $league)->where('sport', $sport)->with('odds')->orderBy('start_date', 'ASC')->get();

        foreach($data as $game) {

            $homeLogo = Team::where('team_name', $game->home_team)->first();
            if(isset($homeLogo->team_name)) {
                $homeLogo = $homeLogo->team_name;
                $homeLogo = asset('images/teams/' . $homeLogo . '.png');
                $game->home_logo = $homeLogo;
            }

            $awayLogo = Team::where('team_name', $game->away_team)->first();
            if(isset($awayLogo->team_name)) {
                $awayLogo = $awayLogo->team_name;
                $awayLogo = asset('images/teams/' . $awayLogo . '.png');
                $game->away_logo = $awayLogo;
            }
        }

        return response()->json(['status' => true, 'total_games' => count($data), 'message' => 'Odds data', 'games' => $data]);
    }

    public function oldApiData() {
        foreach($games as $item) {
            $odds = Http::withHeaders([
                'x-apisports-key' => '4dad24ed2021f3367d062c7976b2c7bf'
            ])->get('https://v1.baseball.api-sports.io/odds', [
                'league' => '1',
                'season' => '2022',
                // 'date' => '2022-07-06',
                'game' => $item->id,
                'bookmaker' => '2',
                'bet' => '1'
            ]);

            $odds = json_decode($odds);
            // return $odds->response;
            $odds = $odds->response;

            if(isset($odds[0]->bookmakers[0]->bets[0]->values[0]->odd)) {
                $homeMoneyline = (float) $odds[0]->bookmakers[0]->bets[0]->values[0]->odd;
            }
            else {
                continue;
                // return response()->json(['games' => $games]);
            }
            $awayMoneyline = (float) $odds[0]->bookmakers[0]->bets[0]->values[1]->odd;

            if($homeMoneyline < 2) {
                $homeMoneyline = round((-100)/($homeMoneyline-1), 0, PHP_ROUND_HALF_DOWN);
            }
            else if($homeMoneyline > 2) {
                $homeMoneyline =  round((($homeMoneyline-1)*100), 0, PHP_ROUND_HALF_DOWN);
            }
            else if($homeMoneyline == 2) {
                $homeMoneyline =  round($homeMoneyline + 100, 0, PHP_ROUND_HALF_DOWN);
            }

            //Passing moneyline value to odds array
            $item->home_money_line = $homeMoneyline;

            if($awayMoneyline > 2) {
                $awayMoneyline =  round((($awayMoneyline-1)*100), 0, PHP_ROUND_HALF_DOWN);
            }
            else if($awayMoneyline < 2) {
                $awayMoneyline = round((-100)/($awayMoneyline-1), 0, PHP_ROUND_HALF_DOWN);
            }
            else if($awayMoneyline == 2) {
                $awayMoneyline =  round($awayMoneyline + 100, 0, PHP_ROUND_HALF_DOWN);
            }

            //Passing moneyline value to odds array
            $item->away_money_line = $awayMoneyline;

            $item->odds = $odds;
        }
        return $data;

        return response()->json(['games' => $games]);
    }
}
