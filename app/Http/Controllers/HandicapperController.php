<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Bet;
use App\Models\League;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
// use App\Helpers\PaginationHelper;
// use App\Providers\AppServiceProvider;

class HandicapperController extends Controller
{
    public function profile($id) {
        $user = User::with('packages')->where('id', $id)->first();
        $arr = ["user_id" => $id, "is_verified" => 1, "auth_id"=>auth()->id(), "status"=>1];
        echo '<pre>';
        print_r($arr);
        echo '</pre>';


        // if(Subscription::where('user_id', auth()->id())->where())
        $builder = DB::table('bets')



        ->join('users', 'bets.user_id', 'users.id')



        ->join('packages', 'users.id', 'packages.user_id')


        ->join('subscriptions', 'packages.id', 'subscriptions.package_id')

        ->select('bets.*', 'users.name as package_owner')


        ->where('bets.user_id', $id)

        ->where('bets.is_verified', 1)

        ->where('subscriptions.user_id', auth()->id())//Attach logged user

        ->where('subscriptions.status', 1);

        //->get();


        $query = str_replace(array('?'), array('\'%s\''), $builder->toSql());
        $query = vsprintf($query, $builder->getBindings());
        dump($query);

        $result = $builder->get();



        dd($result);
        // return $subscribedPicks;

        $data = Bet::where('user_id', $id)->where('is_verified', 1)->whereDate('created_at', Carbon::yesterday())->get();
        // return $data;

        return view('profile', compact('user', 'data', 'subscribedPicks'));
    }

    public function leaderboard() {
        $data = User::where('is_handicapper', 1)->orderBy('verified_win_loss_percentage', 'desc')->paginate(50);




        // $data = DB::table('users')
        //         ->join('bets', 'users.id', 'bets.user_id')
        //         ->select('bets.*', 'users.name')
        //         ->get();
        // return $data;

        return view('leaderboard', compact('data'));
    }

    public function leaderboardApi($leagueName, $sportName, $date,$sortBy=null) {
        Bet::where('league','NCAA')->where('sport','football')->update(['league'=>'NCAAF']);
        Bet::where('league','NCAA')->where('sport','basketball')->update(['league'=>'NCAAB']);

        if($leagueName == 'allleagues' && $date == 'all') {
            $data = User::where('is_handicapper', 1)->with(['bets' => function($q) {
                $q->where('is_verified', 1);
                $q->where('status', 0);
                $q->where('is_won', '!=', 2);
            }])->get();
        }
        else {
            $league = $leagueName;
            $sport = $sportName;

            if($date == 'all') {
                // dd($league);
                $data = User::where('is_handicapper', 1)->with(['bets' => function($q) use ($league, $sport, $date) {
                    $q->where('is_verified', 1);
                    $q->where('league', $league);
                    $q->where('sport', $sport);
                    $q->where('status', 0);
                    $q->where('is_won', '!=', 2);
                }])->get();
            }
            else {
                $daterange = Carbon::today()->subDays($date);
                if(empty($league) || $league=="allleagues"){
                    $data = User::where('is_handicapper', 1)->with(['bets' => function($q) use ($league, $sport, $daterange) {
                        $q->where('is_verified', 1);
                        $q->where('status', 0);
                        $q->where('is_won', '!=', 2);
                        $q->whereBetween('created_at', array($daterange, today()));
                    }])->get();
                }
                else{
                    $data = User::where('is_handicapper', 1)->with(['bets' => function($q) use ($league, $sport, $daterange) {
                        $q->where('is_verified', 1);
                        $q->where('league', $league);
                        $q->where('sport', $sport);
                        $q->where('status', 0);
                        $q->where('is_won', '!=', 2);
                        $q->whereBetween('created_at', array($daterange, today()));
                    }])->get();
                }

                // $products->WhereHas('category', function ($query) use ($search) {
                //     $query->where('name',$search);
                // })->paginate(25)->setPath('');
                // return $data;

            }
        }

        $array = [];
        $collection = collect();

        foreach($data as $key => $user) {
            if($user->bets->isNotEmpty()) {
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
                    }
                    else {
                        $netUnits -= $bet->risk;
                        $units -= $bet->risk;
                    }
                }
                $winLossPercentage = $totalBets > 0 ? ($wins/$totalBets) * 100 : '-';
                $losses = $totalBets - $wins;
                $roi = $risk > 0 ? ($units/$risk) * 100 : '-';

                $data = ['rank' => $key+1, 'user_id' => $user->id, 'name' => $user->name, 'image' => $user->image_with_path, 'win_loss_percentage' => round($winLossPercentage, 2), 'total_bets' => $totalBets, 'wins' => $wins, 'losses' => $losses, 'net_units' => round($netUnits, 2), 'roi' => round($roi, 2)];
                $collection->push($data);
                // array_push($array,$data);
            }
        }

        $sorted = $collection->sortByDesc('total_bets')->sortByDesc('roi')->paginate(20);
        if(!empty($sortBy)){
            $sorted = $collection->sortByDesc($sortBy)->paginate(20);
        }
        // $sorted = $sorted->values()->all();
        return $sorted;

        // $data = User::where('is_handicapper', 1)->orderBy('verified_win_loss_percentage', 'desc')->paginate(5);

        // return $data;
    }

    public function leaderboardSearch(Request $request) {
        if($request->league == 'allleagues' && $request->date == 'all') {
            $data = User::where('is_handicapper', 1)->where('id', 'LIKE', '%' . $request->search. '%')->orWhere('name', 'LIKE', '%' . $request->search. '%')
            ->orWhere('email', 'LIKE', '%' . $request->search. '%')->with(['bets' => function($q) {
                $q->where('is_verified', 1);
                $q->where('status', 0);
                $q->where('is_won', '!=', 2);
            }])->get();
        }
        else {
            // if($request->league == 'NCAAF' && $request->sport == 'football') {
            //     $league = 'NCAA';
            //     $sport = 'football';
            // }
            // else if($request->league == 'NCAAB' && $request->sport == 'basketball') {
            //     $league = 'NCAA';
            //     $sport = 'basketball';
            // }
            // else {
            // }
            $league = $request->league;
            $sport = $request->sport;

            if($request->date == 'all') {
                $data = User::where('is_handicapper', 1)->where('id', 'LIKE', '%' . $request->search. '%')->orWhere('name', 'LIKE', '%' . $request->search. '%')
                ->orWhere('email', 'LIKE', '%' . $request->search. '%')->with(['bets' => function($q) use ($league, $sport) {
                    $q->where('is_verified', 1);
                    $q->where('league', $league);
                    $q->where('sport', $sport);
                    $q->where('status', 0);
                    $q->where('is_won', '!=', 2);
                }])->get();
            }
            else {
                $daterange = Carbon::today()->subDays($request->date);

                $data = User::where('is_handicapper', 1)->where('id', 'LIKE', '%' . $request->search. '%')->orWhere('name', 'LIKE', '%' . $request->search. '%')
                ->orWhere('email', 'LIKE', '%' . $request->search. '%')->with(['bets' => function($q) use ($league, $sport, $daterange) {
                    $q->where('is_verified', 1);
                    $q->where('league', $league);
                    $q->where('sport', $sport);
                    $q->where('status', 0);
                    $q->where('is_won', '!=', 2);
                    $q->whereBetween('created_at', array($daterange, today()));
                }])->get();
            }


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
                    }
                    else {
                        $netUnits -= $bet->risk;
                        $units -= $bet->risk;
                    }
                }
                $winLossPercentage = $totalBets > 0 ? ($wins/$totalBets) * 100 : '-';
                $losses = $totalBets - $wins;
                $roi = $risk > 0 ? ($units/$risk) * 100 : '-';

                $data = ['rank' => $key+1, 'user_id' => $user->id, 'name' => $user->name, 'image' => $user->image, 'win_loss_percentage' => round($winLossPercentage, 2), 'total_bets' => $totalBets, 'wins' => $wins, 'losses' => $losses, 'net_units' => round($netUnits, 2), 'roi' => round($roi, 2)];
                $collection->push($data);
                // array_push($array,$data);
            }
        }

        $sorted = $collection->sortByDesc('total_bets')->sortByDesc('roi');
        $sorted = $sorted->values()->all();
        return $sorted;
    }

    public function historicalRecords() {
        $data = Bet::join('users', 'users.id', '=', 'bets.user_id')
        ->where('bets.is_verified', 1)
        ->where('bets.status', 0)
        ->whereDate('bets.created_at', Carbon::yesterday())
        ->select('bets.*', 'users.name')
        ->orderBy('users.name', 'desc')
        ->get();

        // return $data;

        return view('historical-records', compact('data'));
    }

    public function blindRecords($leagueName, $sportName) {
        if($leagueName == 'allleagues') {
            $user = User::where('id', 2)->with(['bets' => function($q) {
                $q->where('is_verified', 1);
                $q->where('status', 0);
                $q->where('is_won', '!=', 2);
            }])->first();
        }
        else {
            // if($leagueName == 'NCAAF' && $sportName == 'football') {
            //     $league = 'NCAA';
            //     $sport = 'football';
            // }
            // else if($leagueName == 'NCAAB' && $sportName == 'basketball') {
            //     $league = 'NCAA';
            //     $sport = 'basketball';
            // }
            // else {
            // }
            $league = $leagueName;
            $sport = $sportName;

            $user = User::where('id', 2)->with(['bets' => function($q) use ($league, $sport) {
                $q->where('is_verified', 1);
                $q->where('league', $league);
                $q->where('sport', $sport);
                $q->where('status', 0);
                $q->where('is_won', '!=', 2);
            }])->first();
        }
        // return $user;

        $array = [];
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
                }
                else {
                    $netUnits -= $bet->risk;
                    $units -= $bet->risk;
                }
            }
            $winLossPercentage = $totalBets > 0 ? ($wins/$totalBets) * 100 : '-';
            $losses = $totalBets - $wins;
            $roi = $risk > 0 ? ($units/$risk) * 100 : '-';

            $user->api_win_loss_percentage = round($winLossPercentage, 2);
            $user->api_wins = $wins;
            $user->api_losses = $losses;
            $user->api_net_units = round($netUnits, 2);
            $user->api_roi = round($roi, 2);
        }

        return $user;

        // foreach($leagues as $league) {
        //     $bets = Bet::select('bets.*')->where('user_id', 2)->where('league', $league->name)->where('status', 0)->where('is_verified', 1)->get();

        //     $totalBets = 0;
        //     $wins = 0;
        //     $units = 0;
        //     $netUnits = 0;
        //     $risk = 0;
        //     foreach($bets as $bet) {
        //         $wins += $bet->is_won;
        //         $totalBets += 1;
        //         $risk += $bet->risk;
        //         if($bet->is_won == 1) {
        //             $netUnits += $bet->to_win;
        //             $units += $bet->to_win;
        //         }
        //         else {
        //             $netUnits -= $bet->risk;
        //         }
        //     }
        //     if($totalBets > 0) {
        //         $winLossPercentage = $totalBets > 0 ? ($wins/$totalBets) * 100 : '-';
        //         $losses = $totalBets - $wins;
        //         $roi = $risk > 0 ? ($units/$risk) * 100 : '-';

        //         $data = ['id' => $league->id, 'league' => $league->name, 'league_icon' => $league->icon, 'win_loss_percentage' => round($winLossPercentage, 2), 'wins' => $wins, 'losses' => $losses, 'net_units' => round($netUnits, 2), 'roi' => round($roi, 2), 'total_bets' => $totalBets, 'bets' => $bets];
        //         array_push($array,$data);
        //     }

        // }
        // return $array;
    }

    public function topSportsCappers($leagueName, $sportName, $date) {
        // if($leagueName == 'NCAAF' && $sportName == 'football') {
        //     $league = 'NCAA';
        //     $sport = 'football';
        // }
        // else if($leagueName == 'NCAAB' && $sportName == 'basketball') {
        //     $league = 'NCAA';
        //     $sport = 'basketball';
        // }
        // else {
        // }
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
        }
        else {
            $daterange = Carbon::today()->subDays($date);
            $data = User::where('is_handicapper', 1)->with(['bets' => function($q) use ($league, $sport, $daterange) {
                $q->where('is_verified', 1);
                $q->where('league', $league);
                $q->where('sport', $sport);
                $q->where('status', 0);
                $q->where('is_won', '!=', 2);
                $q->whereBetween('created_at', array($daterange, today()));
            }])->get();

            // return $data;
        }
        // return count($data[0]->bets);
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
                    }
                    else {
                        $netUnits -= $bet->risk;
                        $units -= $bet->risk;
                    }
                }
                $winLossPercentage = $totalBets > 0 ? ($wins/$totalBets) * 100 : '-';
                $losses = $totalBets - $wins;
                $roi = $risk > 0 ? ($units/$risk) * 100 : '-';

                $data = ['rank' => $key+1, 'user_id' => $user->id, 'name' => $user->name, 'image' => $user->image, 'win_loss_percentage' => round($winLossPercentage, 2), 'total_bets' => $totalBets, 'wins' => $wins, 'losses' => $losses, 'net_units' => round($netUnits, 2), 'roi' => round($roi, 2)];

                //Minimum of total 10 units won condition
                if(round($netUnits, 2) >= 10) {
                    $collection->push($data);
                }
            }
        }
        $sorted = $collection->sortByDesc('total_bets')->sortByDesc('roi')->take(5);
        $sorted = $sorted->values()->all();
        return $sorted;
    }
}
