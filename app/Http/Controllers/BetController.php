<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bet;
use App\Models\User;
use App\Models\Game;
use App\Models\Subscription;
use Auth;
use App\Mail\BetPlaced;
use App\Mail\SubscribedBetPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTime;

class BetController extends Controller
{
    public function store(Request $request)
    {

        // Check if game is live then reject the bet
        $game = Game::where('game_id', $request->game_id)->first();
        $now = new DateTime();
        $matchTime = new DateTime($game->start_date);
        if ($now >= $matchTime) {
            return response()->json(['status' => false, 'message' => 'This bet is no longer available!']);
        }

        //Check max risks today
        // $todayBets = Bet::whereDate('created_at', today())->where('user_id', $request->user_id)->get();
        // $totalRisks = 0;
        // foreach($todayBets as $item) {
        //     $totalRisks += $item->risk;
        // }
        // if($totalRisks >= 5) {
        //     return response()->json(['status' => false, 'message' => 'Max 5 risks are allowed in a day!']);
        // }

        //Check duplicate bet
        if (Bet::where('user_id', $request->user_id)->where('game_id', $request->game_id)->where('market_name', $request->market_name)->where('odd_name', $request->odd_name)->exists()) {
            return response()->json(['status' => false, 'message' => 'Bet already placed!']);
        }

        $user = User::find($request->user_id);
        //Check for bet odds being less or greater than -300 and then check user's verified status
        if ($request->odds < -300) {
            $verified = 0;
        } else if ($user->is_verified == 1) {
            $verified = 1;
        } else {
            $verified = 0;
        }

        $data = Bet::create([
            'user_id' => $request->user_id,
            'game_id' => $request->game_id,
            'is_verified' => $verified,
            // 'team_id' => $request->team_id,
            'risk' => $request->risk,
            'odds' => $request->odds,
            'to_win' => $request->to_win,
            'home_team' => $request->home_team,
            'away_team' => $request->away_team,
            'wagered_team' => $request->wagered_team,
            'bet_id' => $request->bet_id,
            'status' => 1,
            'is_won' => 0,
            'market_name' => $request->market_name,
            'odd_name' => $request->odd_name,
            'sport' => $request->sport,
            'league' => $request->league,
        ]);

        if ($data) {
            try {
                $user = User::find($data->user_id);
                if ($user->emailoption->bet_placed == 1) {

                    Mail::to(User::find($data->user_id))->send(new BetPlaced($data));
                }
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }

        //Check for package subscribers
        if ($data) {
            $subscribers = DB::table('subscriptions')
                ->join('users', 'subscriptions.user_id', 'users.id')
                ->select('users.*')
                ->where('subscriptions.package_owner_id', $request->user_id)
                ->where('subscriptions.status', 1)
                ->get();

            if (count($subscribers) > 0) {
                foreach ($subscribers as $subscriber) {
                    try {
                        $user = User::find($subscriber->user_id);
                        if ($user->emailoption->subscribed_bet_placed == 1) {

                            Mail::to($subscriber)->send(new SubscribedBetPlaced($data));
                        }
                    } catch (\Throwable $th) {
                        Log::error($th);
                    }
                }
            }
        }

        return response()->json(['status' => true, 'data' => $data, 'message' => 'Bet placed!']);
    }

    public function pendingBets(Request $request)
    {
        $data = Bet::where('user_id', $request->user_id)->where('status', 1)->get();

        return $data;
    }

    public function allBets()
    {
        $data = Bet::latest()->paginate(25);

        return view('dashboard.admin.bets.index', compact('data'));
    }

    public function filterBets(Request $request)
    {
        if ($request->pendingFilter) {
            $data = Bet::where('status', 1)->latest()->paginate(25);

            return view('dashboard.admin.bets.index', compact('data'));
        }

        $data = Bet::latest()->paginate(25);

        return view('dashboard.admin.bets.index', compact('data'));
    }

    public function userBets()
    {
        $data = Bet::where('user_id', auth()->id())->latest()->paginate(25);

        return view('dashboard.user.bets.index', compact('data'));
    }

    public function calculateResult()
    {
    }
}
