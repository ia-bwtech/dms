<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Bet;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\BetWon;
use App\Mail\BetLost;
use Illuminate\Support\Facades\Mail;

class GradeBets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bets:grade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching and updating the results of the bets from the external API';

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
        $bets = Bet::where('status', 1)->get();

        foreach ($bets as $item) {

            //Temporary NCAAF fix
            // if($item->league == 'NCAAF') {
            //     $item->league = 'NCAA';
            // }

            // //Temporary NCAAB fix
            // if($item->league == 'NCAAB') {
            //     $item->league = 'NCAA';
            // }

            $game = Http::get('https://api-external.oddsjam.com/api/v2/grader', [
                'key' => '0483697b-57b6-4787-9bdc-1fc4688bcee7',
                'sport' => $item->sport,
                'league' => $item->league,
                'game_id' => $item->game_id,
                'market_name' => $item->market_name,
                'bet_name' => $item->odd_name,
            ]);

            $game = json_decode($game);

            if (isset($game->errors)) {
                continue;
            }
            if ($game->data->betResult == "Pending") {
                continue;
            }
            if ($game->data->betResult == "Refunded") {
                $item->is_won = 2; //2 is refunded status
                $item->status = 0;
                $item->save();
            }
            if ($game->data->betResult == "Cancelled") {
                $item->is_won = 2; //2 is refunded status
                $item->status = 0;
                $item->save();
            } else if ($game->data->betResult == "Won") {
                if ($item->is_verified == 1) {
                    $item->user->verified_units += $item->to_win;
                    $item->user->verified_wins += 1;
                    $item->user->verified_plays += 1;
                    $item->user->save();

                    $item->is_won = 1;
                    $item->status = 0;
                    $item->save();
                } else if ($item->is_verified == 0) {
                    $item->user->unverified_units += $item->to_win;
                    $item->user->unverified_wins += 1;
                    $item->user->unverified_plays += 1;
                    $item->user->save();

                    $item->is_won = 1;
                    $item->status = 0;
                    $item->save();
                }

                try {
                    if ($item->user->emailoption->bet_won == 1) {

                        Mail::to($item->user)->send(new BetWon($item));
                    }
                } catch (\Throwable $th) {
                    Log::error($th);
                }

                // Log::error('Won bet: ' + $item->odd_name);
            } else if ($game->data->betResult == "Lost") {
                if ($item->is_verified == 1) {
                    $item->user->verified_units -= $item->risk;
                    $item->user->verified_losses += 1;
                    $item->user->verified_plays += 1;
                    $item->user->save();

                    $item->is_won = 0;
                    $item->status = 0;
                    $item->save();
                } else if ($item->is_verified == 0) {
                    $item->user->unverified_units -= $item->risk;
                    $item->user->unverified_losses += 1;
                    $item->user->unverified_plays += 1;
                    $item->user->save();

                    $item->is_won = 0;
                    $item->status = 0;
                    $item->save();
                }

                try {
                    if ($item->user->emailoption->bet_lost == 1) {

                        Mail::to($item->user)->send(new BetLost($item));
                    }
                } catch (\Throwable $th) {
                    Log::error($th);
                }
            }

            if ($item->status == 0) {
                $user = User::with('bets')->where('id', $item->user_id)->first();

                $verifiedRisk = 0;
                $unverifiedRisk = 0;
                foreach ($user->bets as $bet) {
                    if ($bet->status == 0) {                        //Check for active or inactive bets
                        if ($bet->is_won != 2) {                    //Check for non refunded bets
                            if ($bet->is_verified == 1) {
                                $verifiedRisk += $bet->risk;
                            } else if ($bet->is_verified == 0) {
                                $unverifiedRisk += $bet->risk;
                            }
                        }
                    }
                }

                if ($user->is_verified == 1) {
                    //Calculating Win Loss Percentage
                    $total = $user->verified_wins + $user->verified_losses;
                    if ($total > 0) {
                        $user->verified_win_loss_percentage = ($user->verified_wins / $total) * 100;
                        $user->verified_win_loss_percentage = round($user->verified_win_loss_percentage, 1);
                        $user->save();
                    }

                    //Calculating ROI
                    if ($verifiedRisk != 0) {
                        $user->verified_roi = ($user->verified_units / $verifiedRisk) * 100;
                        $user->verified_roi = round($user->verified_roi, 1);
                        $user->save();
                    }
                } else if ($user->is_verified == 0) {
                    //Calculating Win Loss Percentage
                    $total = $user->unverified_wins + $user->unverified_losses;
                    if ($total > 0) {
                        $user->unverified_win_loss_percentage = ($user->unverified_wins / $total) * 100;
                        $user->unverified_win_loss_percentage = round($user->unverified_win_loss_percentage, 1);
                        $user->save();
                    }

                    //Calculating ROI
                    if ($unverifiedRisk != 0) {
                        $user->unverified_roi = ($user->unverified_units / $unverifiedRisk) * 100;
                        $user->unverified_roi = round($user->unverified_roi, 1);
                        $user->save();
                    }
                }

                Log::info('Successfully graded a bet and calculated stats at ' . date('Y-m-d H:i:s A'));
            }
        }
    }
}
