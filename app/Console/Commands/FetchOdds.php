<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Odd;
use App\Models\Game;
use App\Models\League;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FetchOdds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odds:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching and updating the odds from the external API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
                    'checked_date' => date("Y-m-d H:i:s", explode(".", $odd->timestamp)[0]),
                ]);
            }
        }
        Log::info('Successfully fetched odds at ' . date('Y-m-d H:i:s A'));
    }
}
