<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HandicapperController extends Controller
{
    //

    public function my_units($userId)
    {
        $user = User::where('id', $userId)->with('bets')->first();

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
        $allBets = Bet::where('user_id', $userId)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
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
        $last7Bets = Bet::whereBetween('created_at', array($last7DaysDate, today()))->where('user_id', $userId)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
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
        $last14Bets = Bet::whereBetween('created_at', array($last14DaysDate, today()))->where('user_id', $userId)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
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
        $last30Bets = Bet::whereBetween('created_at', array($last30DaysDate, today()))->where('user_id', $userId)->where('status', 0)->where('is_verified', $verified)->where('is_won', '!=', 2)->get();
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
        return $array;
    }



    public function dashboard(Request $request){


        $net_units = $this->my_units($request->user()->id);

        $this->jsonResponseData["status"] = true;
        $this->jsonResponseData["data"] = [
            "net_units" => $net_units
        ];
        return $this->jsonResponse();
    }

    public function top_five_sports_capper($leagueName, $sportName, $date) {
        $league = $leagueName;
        $sport = $sportName;
        if($date == 'all') {
            $data = User::where('is_handicapper', 1)->with(['bets' => function($q) use ($league, $sport) {
                $q->where('is_verified', 1);
                $q->where('league', $league);
                $q->where('sport', $sport);
                $q->where('status', 0);
                $q->where('is_won', '!=', 2);
            }])->get();
        }else{
            $daterange = Carbon::today()->subDays($date);
            $data = User::where('is_handicapper', 1)->with(['bets' => function($q) use ($league, $sport, $daterange) {
                $q->where('is_verified', 1);
                $q->where('league', $league);
                $q->where('sport', $sport);
                $q->where('status', 0);
                $q->where('is_won', '!=', 2);
                $q->whereBetween('created_at', array($daterange, today()));
            }])->get();
        }
        $array = [];
        $collection = collect();
        foreach($data as $key => $user) {
            if(!empty($user->bets)) {
                $totalBets = 0;
                $wins = 0;
                $units = 0;
                $netUnits = 0;
                $risk = 0;
                foreach($user['bets'] as $bet) {
                    $wins += $bet->is_won;
                    $totalBets += 1;
                    $risk += $bet->risk;
                    if($bet->is_won == 1) {
                        $netUnits += $bet->to_win;
                        $units += $bet->to_win;
                    }else{
                        $netUnits -= $bet->risk;
                        $units -= $bet->risk;
                    }
                }
                $winLossPercentage = $totalBets > 0 ? ($wins/$totalBets) * 100 : '-';
                $losses = $totalBets - $wins;
                $roi = $risk > 0 ? ($units/$risk) * 100 : '-';
                $data = [
                    'rank' => $key+1,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'image' => $user->image_with_path,
                    'win_loss_percentage' => round($winLossPercentage, 2),
                    'total_bets' => $totalBets,
                    'wins' => $wins,
                    'losses' => $losses,
                    'net_units' => round($netUnits, 2),
                    'roi' => round($roi, 2)
                ];
                //Minimum of total 10 units won condition
                if(round($netUnits, 2) >= 10) {
                    $collection->push($data);
                }
            }
        }
        $sorted = $collection->sortByDesc('total_bets')->sortByDesc('roi')->take(5);
        $sorted = $sorted->values()->all();
        $this->jsonResponseData["status"] = true;
        $this->jsonResponseData["data"] = $sorted;
        return $this->jsonResponse();
    }
}
