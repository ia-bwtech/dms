<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Odd;
use App\Models\Bet;
use App\Models\Game;
use App\Models\League;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\BetWon;
use App\Mail\BetLost;
use App\Models\AdminPackage;
use App\Models\CMS;
use App\Models\EmailOption;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use DateTime;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $jsonResponseData = ["status"=>false, "message"=>"", "data"=>[]];

    public function index1()
    {
        $data = $this->top10();
        $blindPackages = Package::where('user_id', 2)->get();
        $featured = User::where('is_featured', 1)->with('packages')->first();
        $featuredHandicappers = $this->leaderboardApi('allleagues', 'allsports', 'all');
        // $bannersection=CMS::where('slug','home')->first();
        // dd($bannersection->content);


        return view('welcome', compact('data', 'blindPackages', 'featured', 'featuredHandicappers'));
    }
    public function deactivateSubscriptions()
    {
        $subscriptions = Subscription::all();
        foreach ($subscriptions as $subscription) {
            $duration = $subscription->package->duration;
            if ($duration == 'monthly') {
                $duration = 30;
            }
            if ($duration == 'daily') {
                $duration = 1;
            }
            if ($duration == 'weekly') {
                $duration = 7;
            }
            $expiry_date = $subscription->created_at->addDays($duration);
            $current_date = Carbon::now();

            if ($current_date > $expiry_date) {
                Subscription::where('id', $subscription->id)->update(['status' => 0]);
            }
        }
    }
    public function emailoptions()
    {
        $users = User::all();
        foreach ($users as $user) {
            $emailoption = EmailOption::where('user_id', $user->id)->first();
            if (empty($emailoption)) {
                EmailOption::create([
                    'user_id' => $user->id,
                    'bet_placed' => 1,
                    'bet_won' => 1,
                    'bet_lost' => 1,
                    'subscribed_bet_placed' => 1
                ]);
            }
        }
    }
    public function addAdminPackage()
    {
        $adminpackage = AdminPackage::find(1)->toArray();
        unset($adminpackage['user_id']);
        $handicappers = User::where('is_handicapper', 1)->where('stripe_connected', 0)->get();
        foreach ($handicappers as $item) {
            $package = Package::where('user_id', $item->id)->where('is_admin', 1)->first();
            if (empty($package)) {
                Package::create($adminpackage + ['is_admin' => 1, 'user_id' => $item->id]);
            } else {
                $package1 = Package::where('user_id', $item->id)->where('is_admin', 1)->first();
                $package1->update($adminpackage + ['is_admin' => 1, 'user_id' => $item->id]);
            }
        }
    }

    public function top10()
    {
        // $data = User::where('is_handicapper', 1)->orderBy(function() {
        //     return $this->wins + $this->losses;
        // }, 'desc')->orderBy('win_loss_percentage', 'desc')->take(50)->get();

        return User::where('is_handicapper', 1)->orderBy('verified_win_loss_percentage', 'desc')->take(10)->get();
    }

    public function removeTags($string)
    {
        $omit_words = array('<!DOCTYPE html>', '<html>', '<head>', '</html>', '</head>', '<body>', '</body>');
        $new_string = str_replace($omit_words, '', $string);
        $new_string = trim(preg_replace('/\s\s+/', ' ', $new_string));
        return $new_string;
    }

    public function calculateStats()
    {
        $user = User::with('bets')->where('id', auth()->id())->first();

        if (count($user->bets) != 0) {

            $verifiedRisk = 0;
            $unverifiedRisk = 0;
            foreach ($user->bets as $item) {
                if ($item->status == 0) {                        //Check for active or inactive bets
                    if ($item->is_won != 2) {                    //Check for non refunded bets
                        if ($item->is_verified == 1) {
                            $verifiedRisk += $item->risk;
                        } else if ($item->is_verified == 0) {
                            $unverifiedRisk += $item->risk;
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
        }

        return;
    }

    public function test()
    {
        $game = Game::where('game_id', '27720-21344-2022-10-19')->first();
        $now = new DateTime();
        // dd($now);
        $matchTime = new DateTime($game->start_date);
        // dd($matchTime);
        if ($now >= $matchTime) {
            return response()->json(['status' => false, 'message' => 'This bet is no longer available!']);
        }
        return 1;
    }

    public function leaderboardApi($leagueName, $sportName, $date)
    {
        if ($leagueName == 'allleagues' && $date == 'all') {
            $data = User::where('is_handicapper', 1)->with(['bets' => function ($q) {
                $q->where('is_verified', 1);
                $q->where('status', 0);
                $q->where('is_won', '!=', 2);
            }])->get();
        } else {
            if ($leagueName == 'NCAAF' && $sportName == 'football') {
                $league = 'NCAA';
                $sport = 'football';
            } else if ($leagueName == 'NCAAB' && $sportName == 'basketball') {
                $league = 'NCAA';
                $sport = 'basketball';
            } else {
                $league = $leagueName;
                $sport = $sportName;
            }

            if ($date == 'all') {
                // dd($league);
                $data = User::where('is_handicapper', 1)->with(['bets' => function ($q) use ($league, $sport, $date) {
                    $q->where('is_verified', 1);
                    $q->where('league', $league);
                    $q->where('sport', $sport);
                    $q->where('status', 0);
                    $q->where('is_won', '!=', 2);
                }])->get();
            } else {
                $daterange = Carbon::today()->subDays($date);
                if (empty($league) || $league == "allleagues") {
                    $data = User::where('is_handicapper', 1)->with(['bets' => function ($q) use ($league, $sport, $daterange) {
                        $q->where('is_verified', 1);
                        $q->where('status', 0);
                        $q->where('is_won', '!=', 2);
                        $q->whereBetween('created_at', array($daterange, today()));
                    }])->get();
                } else {
                    $data = User::where('is_handicapper', 1)->with(['bets' => function ($q) use ($league, $sport, $daterange) {
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

        foreach ($data as $key => $user) {
            if ($user->bets->isNotEmpty()) {
                $totalBets = 0;
                $wins = 0;
                $units = 0;
                $netUnits = 0;
                $risk = 0;
                foreach ($user['bets'] as $bet) {
                    $wins += $bet->is_won;
                    $totalBets += 1;
                    $risk += $bet->risk;
                    if ($bet->is_won == 1) {
                        $netUnits += $bet->to_win;
                        $units += $bet->to_win;
                    } else {
                        $netUnits -= $bet->risk;
                        $units -= $bet->risk;
                    }
                }
                $winLossPercentage = $totalBets > 0 ? ($wins / $totalBets) * 100 : '-';
                $losses = $totalBets - $wins;
                $roi = $risk > 0 ? ($units / $risk) * 100 : '-';

                $data = ['rank' => $key + 1, 'user_id' => $user->id, 'name' => $user->name, 'image' => $user->image, 'win_loss_percentage' => round($winLossPercentage, 2), 'total_bets' => $totalBets, 'wins' => $wins, 'losses' => $losses, 'net_units' => round($netUnits, 2), 'roi' => round($roi, 2)];
                $collection->push($data);
                // array_push($array,$data);
            }
        }

        $sorted = $collection->sortByDesc('total_bets')->sortByDesc('roi')->paginate(5);
        // $sorted = $sorted->values()->all();
        return $sorted;

        // $data = User::where('is_handicapper', 1)->orderBy('verified_win_loss_percentage', 'desc')->paginate(5);

        // return $data;
    }

    public function jsonResponse($status_code = 200){
        return response()->json($this->jsonResponseData, $status_code);
    }
}
