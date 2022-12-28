<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bet;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index() {
        $data = Bet::with('user')->whereDate('created_at', Carbon::today())->get();
        $activeBets = Bet::where('status', 1)->count();
        
        return view('dashboard.admin.index', compact('data', 'activeBets'));
    }

    public function handicappers() {
        $data = User::where('is_handicapper', 1)->get();
        $paymentVerifiedCappers = User::where('is_handicapper', 1)->where(function ($query) {
            $query->where('stripe_connected', 1)
            ->orWhere('paypal_connected', 1);
        })->get();
        
        return view('dashboard.admin.handicappers', compact('data', 'paymentVerifiedCappers'));
    }

    public function verifyUser($id) {
        $data = User::findorfail($id);
        $data->is_verified = 1;
        $data->save();

        return redirect('/admin/handicappers')->with('success', "User successfully verified");
    }

    public function editUser($id) {
        $data = User::findorfail($id);

        return view('dashboard.admin.users.edit', compact('data'));
    }

    public function updateUser(Request $request, $id) {
        $data = User::findorfail($id);

        $data->payment_cut_percentage = $request->payment_cut_percentage;
        $data->save();
        return redirect('/admin/handicappers')->with('success', "Profile Updated");
        
        // if ($request->payment_cut_percentage) {
        //     return $request;
        //     auth()->user()->update(['payment_cut_percentage' => $request->payment_cut_percentage]);
        //     $data->payment_cut_percentage = $request->payment_cut_percentage;
        //     $data->save();
        // }

        // auth()->user()->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        // ]);

        return redirect('/admin/handicappers')->with('success', "Profile Updated");
    }

    public function updateFeatured(Request $request) {
        $oldFeatured = User::where('is_featured', 1)->first();
        $oldFeatured->update(['is_featured' => 0]);

        $newFeatured = User::find($request->featured);
        $newFeatured->update(['is_featured' => 1]);

        return redirect('/admin/handicappers')->with('success', "Featured Profile Updated");
    }
}
