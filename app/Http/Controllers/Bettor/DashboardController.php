<?php

namespace App\Http\Controllers\Bettor;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\Game;
use App\Models\Package;
use App\Models\Payment;
use App\Models\sport;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::count();
        $total_earnings = Payment::where('user_id',auth()->user()->id)->sum('amount');
        $handicappers = User::where('is_handicapper', 1)->count();
        $bettors = User::where('is_handicapper', 0)->count();
        $bets = Bet::where('user_id',auth()->user()->id)->count();
        $verified_bets = Bet::where('is_verified', 1)->count();
        $handicapper_earnings = $total_earnings * 0.75;
        $teams = Team::count();
        $sports = sport::count();
        $games = Game::count();
        $packages = Package::where('user_id',auth()->user()->id)->count();
        $transactions = Payment::where('user_id',auth()->user()->id)->count();
        if ($request->date_start != null && $request->date_end != null) {
            $users = User::whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $total_earnings = Payment::whereBetween('created_at', [$request->date_start, $request->date_end])->sum('amount');
            $handicappers = User::where('is_handicapper', 1)->whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $bettors = User::where('is_handicapper', 0)->whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $bets = Bet::whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $verified_bets = Bet::where('is_verified', 1)->whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $handicapper_earnings = $total_earnings * 0.75;
            $teams = Team::whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $sports = sport::whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $games = Game::whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $packages = Package::whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
            $transactions = Payment::whereBetween('created_at', [$request->date_start, $request->date_end])->where('user_id',auth()->user()->id)->count();
        }
        if ($request->ajax()) {
            $data = view('admin.dashboard.ajaxindex', get_defined_vars())->render();

            return response()->json([
                'data' => $data,
                'total' => (string) 5,
                'pagination' => (string) 5
            ]);
        }
        return view('admin.dashboard.bettordashboard', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
