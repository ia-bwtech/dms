<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bet;
use App\Models\league;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Mail\BetWon;
use App\Mail\BetLost;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $data = Bet::whereHas('user', function (Builder $query) {
            $query->where('is_verified', 1);
        })->whereDate('created_at', Carbon::yesterday())->get();

        return view('dashboard.user.index', compact('data'));
    }

    public function bettorsignup(){
        return view('auth.bettor.signup');
    }
    public function handicappersignup(){
        return view('auth.handicapper.signup');
    }
    public function bettorthankyou(){
        return view('auth.bettor.thankyou');
    }
    public function handicapperthankyou(){
        return view('auth.handicapper.thankyou');
    }

    public function myRanking() {

        //         $user = User::with('bets')->where('id', auth()->id())->first();

        //         // $risks = 0;
        //         // foreach($user->bets as $item) {
        //             //Calculating Total Risks
        //             // if($item->status == 0) {
        //             //     $risks += $item->risk;
        //             // }
        //         // }
        // // return $user;
        //         if(count($user->bets) != 0) {
        //             foreach($user->bets as $item) {

        //                 // if($item->status == 0) {
        //                 //     $total = $user->wins + $user->losses;
        //                 //     $user->win_loss_percentage = ($user->wins/$total) * 100;
        //                 //     $user->win_loss_percentage = round($user->win_loss_percentage, 1);
        //                 //     $risks += $item->risk;
        //                 //     $user->roi = ($user->units/$risks) * 100;
        //                 //     $user->save();
        //                 // }

//                 if($item->status == 1) {
//                     $game = Http::get('https://api-external.oddsjam.com/api/v2/grader', [
//                         'key' => '0483697b-57b6-4787-9bdc-1fc4688bcee7',
//                         'sport' => $item->sport,
//                         'league' => $item->league,
//                         'game_id' => $item->game_id,
//                         'market_name' => $item->market_name,
//                         'bet_name' => $item->odd_name,
//                     ]);

//                     $game = json_decode($game);

//                     if(isset($game->errors)) {
//                         continue;
//                     }
//                     if($game->data->betResult == "Pending") {
//                         continue;
//                     }
//                     if($game->data->betResult == "Refunded") {
//                         $item->is_won = 2; //2 is refunded status
//                         $item->status = 0;
//                         $item->save();
//                         continue;
//                     }
//                     // else if($game->betType == "1st Half Run line" || $game->betType == "Run line") {
//                     //     if(str_contains($game->betName, '+')) {

        //                     $game = json_decode($game);

        //                     if(isset($game->errors)) {
        //                         continue;
        //                     }
        //                     if($game->data->betResult == "Pending") {
        //                         continue;
        //                     }
        //                     if($game->data->betResult == "Refunded") {
        //                         $item->is_won = 2; //2 is refunded status
        //                         $item->status = 0;
        //                         $item->save();
        //                         continue;
        //                     }
        //                     // else if($game->betType == "1st Half Run line" || $game->betType == "Run line") {
        //                     //     if(str_contains($game->betName, '+')) {

        //                     //     }
        //                     // }
        //                     else if($game->data->betResult == "Won") {
        //                         if($item->is_verified == 1) {
        //                             $user->verified_units += $item->to_win;
        //                             $user->verified_wins += 1;
        //                             $user->verified_plays += 1;
        //                             $user->save();

        //                             $item->is_won = 1;
        //                             $item->status = 0;
        //                             $item->save();
        //                         }
        //                         else if($item->is_verified == 0) {
        //                             $user->unverified_units += $item->to_win;
        //                             $user->unverified_wins += 1;
        //                             $user->unverified_plays += 1;
        //                             $user->save();

        //                             $item->is_won = 1;
        //                             $item->status = 0;
        //                             $item->save();
        //                         }

        //                         try {
        //                             Mail::to($user)->send(new BetWon($item));
        //                         } catch (\Throwable $th) {
        //                             Log::error($th);
        //                         }

        //                         // Log::error('Won bet: ' + $item->odd_name);
        //                     }
        //                     else if($game->data->betResult == "Lost") {
        //                         if($item->is_verified == 1) {
        //                             $user->verified_units -= $item->risk;
        //                             $user->verified_losses += 1;
        //                             $user->verified_plays += 1;
        //                             $user->save();

        //                             $item->is_won = 0;
        //                             $item->status = 0;
        //                             $item->save();
        //                         }
        //                         else if($item->is_verified == 0) {
        //                             $user->unverified_units -= $item->risk;
        //                             $user->unverified_losses += 1;
        //                             $user->unverified_plays += 1;
        //                             $user->save();

        //                             $item->is_won = 0;
        //                             $item->status = 0;
        //                             $item->save();
        //                         }

        //                         try {
        //                             Mail::to($user)->send(new BetLost($item));
        //                         } catch (\Throwable $th) {
        //                             Log::error($th);
        //                         }

        //                         // Log::error('Lost bet: ' + $item->odd_name);
        //                     }

//                     // //Calculating ROI
//                     // if($risks > 0) {
//                     //     $user->roi = ($user->units/$risks) * 100;
//                     //     $user->save();
//                     // }


//                     // return $games->errors;
//                     // $games = $games->data;

//                     // $game = Http::withHeaders([
//                     //     'x-apisports-key' => '4dad24ed2021f3367d062c7976b2c7bf'
//                     // ])->get('https://v1.baseball.api-sports.io/games', [
//                     //     'id' => $item->game_id,
//                     //     'timezone' => 'America/New_York'
//                     // ]);

//                     // $game = json_decode($game);
//                     // $game = $game->response;

//                     // foreach($game as $singleGame) {
//                     //     if($singleGame->status->long == 'Finished') {
//                     //         $winner = $singleGame->scores->home->total > $singleGame->scores->away->total ? $singleGame->teams->home->id : $singleGame->teams->away->id;

//                     //         if($winner == $item->team_id) {
//                     //             $user->units += $item->to_win;
//                     //             $user->wins += 1;
//                     //             $user->total_plays += 1;
//                     //             $user->save();

//                     //             $item->is_won = 1;
//                     //             $item->status = 0;
//                     //             $item->save();
//                     //         }
//                     //         else {
//                     //             $user->units -= $item->risk;
//                     //             $user->losses += 1;
//                     //             $user->total_plays += 1;
//                     //             $user->save();

//                     //             $item->is_won = 0;
//                     //             $item->status = 0;
//                     //             $item->save();
//                     //         }
//                     //         //Calculating Win Loss Percentage
//                     //         $total = $user->wins + $user->losses;
//                     //         $user->win_loss_percentage = ($user->wins/$total) * 100;
//                     //         $user->win_loss_percentage = round($user->win_loss_percentage, 1);
//                     //         $user->save();

        //                     // // return $risks;
        //                     // Log::error('Risks');
        //                     // Log::error($risks);
        //                     // Log::error('ROI');
        //                     // Log::error($user->roi);

        //                     // //Calculating ROI
        //                     // if($risks > 0) {
        //                     //     $user->roi = ($user->units/$risks) * 100;
        //                     //     $user->save();
        //                     // }


        //                     // return $games->errors;
        //                     // $games = $games->data;

        //                     // $game = Http::withHeaders([
        //                     //     'x-apisports-key' => '4dad24ed2021f3367d062c7976b2c7bf'
        //                     // ])->get('https://v1.baseball.api-sports.io/games', [
        //                     //     'id' => $item->game_id,
        //                     //     'timezone' => 'America/New_York'
        //                     // ]);

        //                     // $game = json_decode($game);
        //                     // $game = $game->response;

        //                     // foreach($game as $singleGame) {
        //                     //     if($singleGame->status->long == 'Finished') {
        //                     //         $winner = $singleGame->scores->home->total > $singleGame->scores->away->total ? $singleGame->teams->home->id : $singleGame->teams->away->id;

        //                     //         if($winner == $item->team_id) {
        //                     //             $user->units += $item->to_win;
        //                     //             $user->wins += 1;
        //                     //             $user->total_plays += 1;
        //                     //             $user->save();

        //                     //             $item->is_won = 1;
        //                     //             $item->status = 0;
        //                     //             $item->save();
        //                     //         }
        //                     //         else {
        //                     //             $user->units -= $item->risk;
        //                     //             $user->losses += 1;
        //                     //             $user->total_plays += 1;
        //                     //             $user->save();

        //                     //             $item->is_won = 0;
        //                     //             $item->status = 0;
        //                     //             $item->save();
        //                     //         }
        //                     //         //Calculating Win Loss Percentage
        //                     //         $total = $user->wins + $user->losses;
        //                     //         $user->win_loss_percentage = ($user->wins/$total) * 100;
        //                     //         $user->win_loss_percentage = round($user->win_loss_percentage, 1);
        //                     //         $user->save();

        //                     //         //Calculating ROI
        //                     //         $user->roi = ($user->units/$risks) * 100;
        //                     //         $user->save();
        //                     //     }
        //                     // }
        //                 }
        //             }
        //         }

        //         $this->calculateStats();

        //         // $data = Bet::find(auth()->id())->where('status', 1)->get();

        //         // return view('my-ranking', compact('data'));

        // if (Bet::where('user_id', auth()->id())->where('status', 1)->exists()) {
        //     $data = Bet::where('user_id', auth()->id())->where('status', 1)->get();

        //     return view('my-ranking', compact('data'));
        // }

        return view('my-ranking');
    }

    public function stats($id)
    {
        return response()->json(['stats' => User::find($id)]);
    }

    public function units($id)
    {
        $user = User::where('id', $id)->with('bets')->first();

        if ($user->is_verified == 1) {
            $verified = 1;
        } else {
            $verified = 0;
        }

        $last7DaysDate = Carbon::today()->subDays(7);
        $last14DaysDate = Carbon::today()->subDays(14);
        $last30DaysDate = Carbon::today()->subDays(30);

        $array = [];

        //all time stats
        $allBets = Bet::where('user_id', $id)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
        $totalAllWins = 0;
        $totalAllBets = 0;
        $totalAllUnits = 0;
        $totalAllNetUnits = 0;
        $totalAllRisk = 0;
        foreach ($allBets as $bet) {
            $totalAllWins += $bet->is_won;
            $totalAllBets += 1;
            $totalAllRisk += $bet->risk;
            if ($bet->is_won == 1) {
                $totalAllNetUnits += $bet->to_win;
                $totalAllUnits += $bet->to_win;
            } else {
                $totalAllNetUnits -= $bet->risk;
            }
        }
        $totalAllWinLossPercentage = $totalAllBets > 0 ? ($totalAllWins / $totalAllBets) * 100 : '-';
        $totalAllLosses = $totalAllBets - $totalAllWins;
        $totalAllRoi = $totalAllRisk > 0 ? ($totalAllUnits / $totalAllRisk) * 100 : '-';
        $allTimeData = ['bets' => $allBets, 'name' => 'All Time', 'net_units' => round($totalAllNetUnits, 2), 'wins' => $totalAllWins, 'losses' => $totalAllLosses, 'win_loss_percentage' => round($totalAllWinLossPercentage, 2), 'roi' => round($totalAllRoi, 2)];
        array_push($array, $allTimeData);

        //7 day stats
        $last7Bets = Bet::whereBetween('created_at', array($last7DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
        $totalLast7Wins = 0;
        $totalLast7Bets = 0;
        $totalLast7Units = 0;
        $totalLast7NetUnits = 0;
        $totalLast7Risk = 0;
        foreach ($last7Bets as $bet) {
            $totalLast7Wins += $bet->is_won;
            $totalLast7Bets += 1;
            $totalLast7Risk += $bet->risk;
            if ($bet->is_won == 1) {
                $totalLast7NetUnits += $bet->to_win;
                $totalLast7Units += $bet->to_win;
            } else {
                $totalLast7NetUnits -= $bet->risk;
            }
        }
        $totalLast7WinLossPercentage = $totalLast7Bets > 0 ? ($totalLast7Wins / $totalLast7Bets) * 100 : '-';
        $totalLast7Losses = $totalLast7Bets - $totalLast7Wins;
        $totalLast7Roi = $totalLast7Risk > 0 ? ($totalLast7Units / $totalLast7Risk) * 100 : '-';
        $Last7Data = ['bets' => $last7Bets, 'name' => '7 Day', 'net_units' => round($totalLast7NetUnits, 2), 'wins' => $totalLast7Wins, 'losses' => $totalLast7Losses, 'win_loss_percentage' => round($totalLast7WinLossPercentage, 2), 'roi' => round($totalLast7Roi, 2)];
        array_push($array, $Last7Data);

        //14 day stats
        $last14Bets = Bet::whereBetween('created_at', array($last14DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
        $totalLast14Wins = 0;
        $totalLast14Bets = 0;
        $totalLast14Units = 0;
        $totalLast14NetUnits = 0;
        $totalLast14Risk = 0;
        foreach ($last14Bets as $bet) {
            $totalLast14Wins += $bet->is_won;
            $totalLast14Bets += 1;
            $totalLast14Risk += $bet->risk;
            if ($bet->is_won == 1) {
                $totalLast14NetUnits += $bet->to_win;
                $totalLast14Units += $bet->to_win;
            } else {
                $totalLast14NetUnits -= $bet->risk;
            }
        }
        $totalLast14WinLossPercentage = $totalLast14Bets > 0 ? ($totalLast14Wins / $totalLast14Bets) * 100 : '-';
        $totalLast14Losses = $totalLast14Bets - $totalLast14Wins;
        $totalLast14Roi = $totalLast14Risk > 0 ? ($totalLast14Units / $totalLast14Risk) * 100 : '-';
        $Last14Data = ['bets' => $last14Bets, 'name' => '14 Day', 'net_units' => round($totalLast14NetUnits, 2), 'wins' => $totalLast14Wins, 'losses' => $totalLast14Losses, 'win_loss_percentage' => round($totalLast14WinLossPercentage, 2), 'roi' => round($totalLast14Roi, 2)];
        array_push($array, $Last14Data);

        //30 day stats
        $last30Bets = Bet::whereBetween('created_at', array($last30DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
        $totalLast30Wins = 0;
        $totalLast30Bets = 0;
        $totalLast30Units = 0;
        $totalLast30NetUnits = 0;
        $totalLast30Risk = 0;
        foreach ($last30Bets as $bet) {
            $totalLast30Wins += $bet->is_won;
            $totalLast30Bets += 1;
            $totalLast30Risk += $bet->risk;
            if ($bet->is_won == 1) {
                $totalLast30NetUnits += $bet->to_win;
                $totalLast30Units += $bet->to_win;
            } else {
                $totalLast30NetUnits -= $bet->risk;
            }
        }
        $totalLast30WinLossPercentage = $totalLast14Risk > 0 ? ($totalLast30Wins / $totalLast14Risk) * 100 : '-';
        $totalLast30Losses = $totalLast30Bets - $totalLast30Wins;
        $totalLast30Roi = $totalLast30Risk > 0 ? ($totalLast30Units / $totalLast30Risk) * 100 : '-';
        $Last30Data = ['bets' => $last30Bets, 'name' => '30 Day', 'net_units' => round($totalLast30NetUnits, 2), 'wins' => $totalLast30Wins, 'losses' => $totalLast30Losses, 'win_loss_percentage' => round($totalLast30WinLossPercentage, 2), 'roi' => round($totalLast30Roi, 2)];
        array_push($array, $Last30Data);

        // if($user->is_verified == 1) {
        //     //all time stats
        //     $allBets = Bet::where('user_id', $id)->where('status', 0)->where('is_verified', 1)->get();
        //     $totalAllWins = 0;
        //     $totalAllBets = 0;
        //     $totalAllUnits = 0;
        //     $totalAllNetUnits = 0;
        //     $totalAllRisk = 0;
        //     foreach($allBets as $bet) {
        //         $totalAllWins += $bet->is_won;
        //         $totalAllBets += 1;
        //         $totalAllRisk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $totalAllNetUnits += $bet->to_win;
        //             $totalAllUnits += $bet->to_win;
        //         }
        //         else {
        //             $totalAllNetUnits -= $bet->risk;
        //         }
        //     }
        //     $totalAllWinLossPercentage = $totalAllBets > 0 ? ($totalAllWins/$totalAllBets) * 100 : '-';
        //     $totalAllLosses = $totalAllBets - $totalAllWins;
        //     $totalAllRoi = $totalAllRisk > 0 ? ($totalAllUnits/$totalAllRisk) * 100 : '-';
        //     $allTimeData = ['bets' => $allBets, 'name' => 'All Time', 'net_units' => $totalAllNetUnits, 'wins' => $totalAllWins, 'losses' => $totalAllLosses, 'win_loss' => $totalAllWinLossPercentage, 'roi' => $totalAllRoi];
        //     array_push($array, $allTimeData);

        //     //7 day stats
        //     $last7Bets = Bet::whereBetween('created_at', array($last7DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', 1)->get();
        //     $totalLast7Wins = 0;
        //     $totalLast7Bets = 0;
        //     $totalLast7Units = 0;
        //     $totalLast7NetUnits = 0;
        //     $totalLast7Risk = 0;
        //     foreach($last7Bets as $bet) {
        //         $totalLast7Wins += $bet->is_won;
        //         $totalLast7Bets += 1;
        //         $totalLast7Risk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $totalLast7NetUnits += $bet->to_win;
        //             $totalLast7Units += $bet->to_win;
        //         }
        //         else {
        //             $totalLast7NetUnits -= $bet->risk;
        //         }
        //     }
        //     $totalLast7WinLossPercentage = $totalLast7Bets > 0 ? ($totalLast7Wins/$totalLast7Bets) * 100 : '-';
        //     $totalLast7Losses = $totalLast7Bets - $totalLast7Wins;
        //     $totalLast7Roi = $totalLast7Risk > 0 ? ($totalLast7Units/$totalLast7Risk) * 100 : '-';
        //     $Last7Data = ['bets' => $last7Bets, 'name' => '7 Day', 'net_units' => $totalLast7NetUnits, 'wins' => $totalLast7Wins, 'losses' => $totalLast7Losses, 'win_loss' => $totalLast7WinLossPercentage, 'roi' => $totalLast7Roi];
        //     array_push($array, $Last7Data);

        //     //14 day stats
        //     $last14Bets = Bet::whereBetween('created_at', array($last14DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', 1)->get();
        //     $totalLast14Wins = 0;
        //     $totalLast14Bets = 0;
        //     $totalLast14Units = 0;
        //     $totalLast14NetUnits = 0;
        //     $totalLast14Risk = 0;
        //     foreach($last14Bets as $bet) {
        //         $totalLast14Wins += $bet->is_won;
        //         $totalLast14Bets += 1;
        //         $totalLast14Risk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $totalLast14NetUnits += $bet->to_win;
        //             $totalLast14Units += $bet->to_win;
        //         }
        //         else {
        //             $totalLast14NetUnits -= $bet->risk;
        //         }
        //     }
        //     $totalLast14WinLossPercentage = $totalLast14Bets > 0 ? ($totalLast14Wins/$totalLast14Bets) * 100 : '-';
        //     $totalLast14Losses = $totalLast14Bets - $totalLast14Wins;
        //     $totalLast14Roi = $totalLast14Risk > 0 ? ($totalLast14Units/$totalLast14Risk) * 100 : '-';
        //     $Last14Data = ['bets' => $last14Bets, 'name' => '14 Day', 'net_units' => $totalLast14NetUnits, 'wins' => $totalLast14Wins, 'losses' => $totalLast14Losses, 'win_loss' => $totalLast14WinLossPercentage, 'roi' => $totalLast14Roi];
        //     array_push($array, $Last14Data);

        //     //30 day stats
        //     $last30Bets = Bet::whereBetween('created_at', array($last30DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', 1)->get();
        //     $totalLast30Wins = 0;
        //     $totalLast30Bets = 0;
        //     $totalLast30Units = 0;
        //     $totalLast30NetUnits = 0;
        //     $totalLast30Risk = 0;
        //     foreach($last30Bets as $bet) {
        //         $totalLast30Wins += $bet->is_won;
        //         $totalLast30Bets += 1;
        //         $totalLast30Risk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $totalLast30NetUnits += $bet->to_win;
        //             $totalLast30Units += $bet->to_win;
        //         }
        //         else {
        //             $totalLast30NetUnits -= $bet->risk;
        //         }
        //     }
        //     $totalLast30WinLossPercentage = $totalLast14Risk > 0 ? ($totalLast30Wins/$totalLast14Risk) * 100 : '-';
        //     $totalLast30Losses = $totalLast30Bets - $totalLast30Wins;
        //     $totalLast30Roi = $totalLast30Risk > 0 ? ($totalLast30Units/$totalLast30Risk) * 100 : '-';
        //     $Last30Data = ['bets' => $last30Bets, 'name' => '30 Day', 'net_units' => $totalLast30NetUnits, 'wins' => $totalLast30Wins, 'losses' => $totalLast30Losses, 'win_loss' => $totalLast30WinLossPercentage, 'roi' => $totalLast30Roi];
        //     array_push($array, $Last30Data);
        // }
        // else if($user->is_verified == 0) {
        //     //all time stats
        //     $allBets = Bet::where('user_id', $id)->where('status', 0)->where('is_verified', 0)->get();
        //     $totalAllWins = 0;
        //     $totalAllBets = 0;
        //     $totalAllUnits = 0;
        //     $totalAllNetUnits = 0;
        //     $totalAllRisk = 0;
        //     foreach($allBets as $bet) {
        //         $totalAllWins += $bet->is_won;
        //         $totalAllBets += 1;
        //         $totalAllRisk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $totalAllNetUnits += $bet->to_win;
        //             $totalAllUnits += $bet->to_win;
        //         }
        //         else {
        //             $totalAllNetUnits -= $bet->risk;
        //         }
        //     }
        //     $totalAllWinLossPercentage = ($totalAllWins/$totalAllBets) * 100;
        //     $totalAllLosses = $totalAllBets - $totalAllWins;
        //     $totalAllRoi = ($totalAllUnits/$totalAllRisk) * 100;
        //     $allTimeData = ['bets' => $allBets, 'net_units' => $totalAllNetUnits, 'wins' => $totalAllWins, 'losses' => $totalAllLosses, 'win_loss' => $totalAllWinLossPercentage, 'roi' => $totalAllRoi];

        //     //7 day stats
        //     $last7Bets = Bet::whereBetween('created_at', array($last7DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', 0)->get();
        //     $totalLast7Wins = 0;
        //     $totalLast7Bets = 0;
        //     $totalLast7Units = 0;
        //     $totalLast7NetUnits = 0;
        //     $totalLast7Risk = 0;
        //     foreach($last7Bets as $bet) {
        //         $totalLast7Wins += $bet->is_won;
        //         $totalLast7Bets += 1;
        //         $totalLast7Risk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $totalLast7NetUnits += $bet->to_win;
        //             $totalLast7Units += $bet->to_win;
        //         }
        //         else {
        //             $totalLast7NetUnits -= $bet->risk;
        //         }
        //     }
        //     $totalLast7WinLossPercentage = ($totalLast7Wins/$totalLast7Bets) * 100;
        //     $totalLast7Losses = $totalLast7Bets - $totalLast7Wins;
        //     $totalLast7Roi = ($totalLast7Units/$totalLast7Risk) * 100;
        //     $Last7Data = ['bets' => $last7Bets, 'net_units' => $totalLast7NetUnits, 'wins' => $totalLast7Wins, 'losses' => $totalLast7Losses, 'win_loss' => $totalLast7WinLossPercentage, 'roi' => $totalLast7Roi];

        //     //14 day stats
        //     $last14Bets = Bet::whereBetween('created_at', array($last14DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', 0)->get();
        //     $totalLast14Wins = 0;
        //     $totalLast14Bets = 0;
        //     $totalLast14Units = 0;
        //     $totalLast14NetUnits = 0;
        //     $totalLast14Risk = 0;
        //     foreach($last14Bets as $bet) {
        //         $totalLast14Wins += $bet->is_won;
        //         $totalLast14Bets += 1;
        //         $totalLast14Risk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $totalLast14NetUnits += $bet->to_win;
        //             $totalLast14Units += $bet->to_win;
        //         }
        //         else {
        //             $totalLast14NetUnits -= $bet->risk;
        //         }
        //     }
        //     $totalLast14WinLossPercentage = ($totalLast14Wins/$totalLast14Bets) * 100;
        //     $totalLast14Losses = $totalLast14Bets - $totalLast14Wins;
        //     $totalLast14Roi = ($totalLast14Units/$totalLast14Risk) * 100;
        //     $Last14Data = ['bets' => $last14Bets, 'net_units' => $totalLast14NetUnits, 'wins' => $totalLast14Wins, 'losses' => $totalLast14Losses, 'win_loss' => $totalLast14WinLossPercentage, 'roi' => $totalLast14Roi];

        //     //30 day stats
        //     $last30Bets = Bet::whereBetween('created_at', array($last30DaysDate, today()))->where('user_id', $id)->where('status', 0)->where('is_verified', 0)->get();
        //     $totalLast30Wins = 0;
        //     $totalLast30Bets = 0;
        //     $totalLast30Units = 0;
        //     $totalLast30NetUnits = 0;
        //     $totalLast30Risk = 0;
        //     foreach($last30Bets as $bet) {
        //         $totalLast30Wins += $bet->is_won;
        //         $totalLast30Bets += 1;
        //         $totalLast30Risk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $totalLast30NetUnits += $bet->to_win;
        //             $totalLast30Units += $bet->to_win;
        //         }
        //         else {
        //             $totalLast30NetUnits -= $bet->risk;
        //         }
        //     }
        //     $totalLast30WinLossPercentage = ($totalLast30Wins/$totalLast30Bets) * 100;
        //     $totalLast30Losses = $totalLast30Bets - $totalLast30Wins;
        //     $totalLast30Roi = ($totalLast30Units/$totalLast30Risk) * 100;
        //     $Last30Data = ['bets' => $last30Bets, 'net_units' => $totalLast30NetUnits, 'wins' => $totalLast30Wins, 'losses' => $totalLast30Losses, 'win_loss' => $totalLast30WinLossPercentage, 'roi' => $totalLast30Roi];
        // }

        return $array;
    }

    public function sportsUnits($id)
    {
        $user = User::where('id', $id)->with('bets')->first();
        $leagues = league::all();

        // foreach($leagues as $item) {
        //     if($item->sport->name == 'football' && $item->name == 'NCAA') {
        //         $item->name = 'NCAAF';
        //     }
        //     else if($item->sport->name == 'basketball' && $item->name == 'NCAA') {
        //         $item->name = 'NCAAB';
        //     }
        // }
        // return $leagues;

        if ($user->is_verified == 1) {
            $verified = 1;
        } else {
            $verified = 0;
        }

        $array = [];
        foreach($leagues as $league) {
            $bets = Bet::where('user_id', $id)->where('league', $league->name)->where('sport', $league->sport->name)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
            if ($league->sport->name == 'football' && $league->name == 'NCAA') {
                $bets = Bet::where('user_id', $id)->whereIn('league', ['NCAA', 'NCAAF'])->where('sport', $league->sport->name)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
            } else if ($league->sport->name == 'basketball' && $league->name == 'NCAA') {
                $bets = Bet::where('user_id', $id)->whereIn('league', ['NCAA', 'NCAAB'])->where('sport', $league->sport->name)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
            }
            else{
                $bets = Bet::where('user_id', $id)->where('league', $league->name)->where('sport', $league->sport->name)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
            }
            $totalBets = 0;
            $wins = 0;
            $units = 0;
            $netUnits = 0;
            $risk = 0;
            foreach ($bets as $bet) {
                $wins += $bet->is_won;
                $totalBets += 1;
                $risk += $bet->risk;
                if ($bet->is_won == 1) {
                    $netUnits += $bet->to_win;
                    $units += $bet->to_win;
                } else {
                    $netUnits -= $bet->risk;
                }
            }
            $winLossPercentage = $totalBets > 0 ? ($wins / $totalBets) * 100 : '-';
            $losses = $totalBets - $wins;
            $roi = $risk > 0 ? ($units/$risk) * 100 : '-';

            $data = ['id' => $league->id, 'league' => $league->name, 'league_icon' => $league->icon, 'win_loss_percentage' => round($winLossPercentage, 2), 'wins' => $wins, 'losses' => $losses, 'net_units' => round($netUnits, 2), 'roi' => round($roi, 2), 'bets' => $bets];
            array_push($array, $data);
        }
        return $array;
    }

    public function changeVerifiedStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->update([
            'is_verified' => $request->status
        ]);
    }
}
