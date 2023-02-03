<?php

namespace App\Http\Controllers\Admin;

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
        $payments = Payment::all();
        $total_handicapper_earnings = 0;
        foreach ($payments as $payment) {
            $amount = $payment->amount / 100;
            $amount = $amount - (($payment->user->payment_cut_percentage / 100) * ($amount));
            $total_handicapper_earnings += $amount;
        }
        $total_earnings = Payment::where('user_id', auth()->user()->id)->sum('amount') / 100;
        $aftercut = $total_earnings - ((auth()->user()->payment_cut_percentage / 100) * ($total_earnings));

        $users = User::count();
        $total_earnings = Payment::sum('amount');
        $handicappers = User::where('is_handicapper', 1)->count();
        $bettors = User::where('is_handicapper', 0)->count();
        $bets = Bet::count();
        $verified_bets = Bet::where('is_verified', 1)->count();
        $handicapper_earnings = $total_earnings * 0.75;
        $teams = Team::count();
        $sports = sport::count();
        $games = Game::count();
        $packages = Package::count();
        $transactions = Payment::count();
        if ($request->date_start != null && $request->date_end != null) {
            $users = User::whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $total_earnings = Payment::whereBetween('created_at', [$request->date_start, $request->date_end])->sum('amount');
            $handicappers = User::where('is_handicapper', 1)->whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $bettors = User::where('is_handicapper', 0)->whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $bets = Bet::whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $verified_bets = Bet::where('is_verified', 1)->whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $handicapper_earnings = $total_earnings * 0.75;
            $teams = Team::whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $sports = sport::whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $games = Game::whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $packages = Package::whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $transactions = Payment::whereBetween('created_at', [$request->date_start, $request->date_end])->count();
            $payments = Payment::whereBetween('created_at', [$request->date_start, $request->date_end])->get();
            $total_handicapper_earnings = 0;
            foreach ($payments as $payment) {
                $amount = $payment->amount / 100;
                $amount = $amount - (($payment->user->payment_cut_percentage / 100) * ($amount));
                $total_handicapper_earnings += $amount;
            }
        }
        if ($request->ajax()) {
            $data = view('admin.dashboard.ajaxindex', get_defined_vars())->render();

            return response()->json([
                'data' => $data,
                'total' => (string) 5,
                'pagination' => (string) 5
            ]);
        }
        return view('admin.dashboard.index', get_defined_vars());
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
