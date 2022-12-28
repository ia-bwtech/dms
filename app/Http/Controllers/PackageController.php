<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class PackageController extends Controller
{
	public function index() {

		$data = Package::where('user_id', auth()->user()->id)->get();
		// $subscriptions = DB::table('payments')
        //     ->join('users', 'payments.user_id', '=', 'users.id')
        //     ->join('packages', 'payments.package_id', '=', 'packages.id')
        //     ->select('packages.*', 'payments.*')
		// 	->where('users.id', auth()->user()->id)
        //     ->get();

		$subscriptions = Subscription::where('user_id', auth()->user()->id)->get();
		// return $subscriptions;

		return view('dashboard.user.packages.index', compact('data', 'subscriptions'));
	}

	public function create() {
        if (auth()->user()->is_handicapper == 1){

            return view('dashboard.user.packages.create');
        }

	}

	public function store(Request $request) {
        if (auth()->user()->is_handicapper == 1){
		// return $request;
		if($request->duration == 'custom') {
			if($request->from_date == null || $request->to_date == null) {
				// $from_date = Carbon::createFromFormat('Y-m-d',  $request->from_date);
				// $to_date = Carbon::createFromFormat('Y-m-d',  $request->to_date);
				// if($from_date->gt($to_date)) {
				// 	$item->late = 'Late';
				// }

				return redirect()->back()->with('error', 'From and to dates are required');
			}
		}

		$data = Package::create([
			'user_id' => Auth::id(),
			'name' => $request->name,
			'price' => $request->price,
			'description' => $request->description,
			'duration' => $request->duration,
			'from_date' => $request->from_date,
			'to_date' => $request->to_date,
		]);

		return redirect()->route('user.packages')->with('success', 'Package created successfully!');
    }
	}

	public function checkout($id) {

		if (App::environment('local')) {
			$stripeKey = config('values.stripe_test');
			$stripePublishableKey = config('values.stripe_test_publishable');
		}
		else if(App::environment('production')) {
			$stripeKey = config('values.stripe_live');
			$stripePublishableKey = config('values.stripe_live_publishable');
		}
		\Stripe\Stripe::setApiKey($stripeKey);

		$data = Package::findorfail($id);
		$user = User::find($data->user_id);

		try {

			if(in_array($data->user->id, [2])) {
				$amount = $data->price * 100;
				// return 'amount: ' . $amount;

				// Set your secret key. Remember to switch to your live secret key in production.
				// See your keys here: https://dashboard.stripe.com/apikeys
				$intent = \Stripe\PaymentIntent::create([
					'amount' => $amount,
					'currency' => 'usd',
					'payment_method_types' => ['card'],
					'description' => $data->id,
				]);

				return view('package-checkout', compact('data', 'intent', 'stripePublishableKey'));
			}
			else if($user->payment_cut_percentage == 0) {
				$amount = $data->price * 100;
				// return 'amount: ' . $amount;

				if($data->user->stripe_connected == 1) {
					// Set your secret key. Remember to switch to your live secret key in production.
					// See your keys here: https://dashboard.stripe.com/apikeys
					$intent = \Stripe\PaymentIntent::create([
						'amount' => $amount,
						'currency' => 'usd',
						'payment_method_types' => ['card'],
						'transfer_data' => [
							'destination' => $user->stripe_id,
						],
						'description' => $data->id,
					]);

					return view('package-checkout', compact('data', 'intent', 'stripePublishableKey'));
				}
				else if($data->user->paypal_connected == 1) {
					return view('package-checkout', compact('data'));
				}
				else {
					return redirect()->back()->with('error', 'Error. Payment method not fully connected.');
				}
			}
			else {
				$amount = $data->price;
				$split = 100;
				if($user->payment_cut_percentage != null || $user->payment_cut_percentage > 0) {
					$split = $amount * ($user->payment_cut_percentage/100);
					// $amount = $amount - $split;
					$amount = $amount * 100;
					$split = $split * 100;
				}
				else {
					$amount *= 100;
				}
				// return 'amount: ' . $amount . ' split: ' . $split;

				if($data->user->stripe_connected == 1) {
					// Set your secret key. Remember to switch to your live secret key in production.
					// See your keys here: https://dashboard.stripe.com/apikeys
					$intent = \Stripe\PaymentIntent::create([
						'amount' => $amount,
						'currency' => 'usd',
						'payment_method_types' => ['card'],
						'application_fee_amount' => $split,
						'transfer_data' => [
							'destination' => $user->stripe_id,
						],
						'description' => $data->id,
					]);

					return view('package-checkout', compact('data', 'intent', 'stripePublishableKey'));
				}
				else if($data->user->paypal_connected == 1) {
					return view('package-checkout', compact('data'));
				}
				else {
					return redirect()->back()->with('error', 'Error. Payment method not fully connected.');
				}
			}

		} catch (\Throwable $th) {
			Log::error($th);
			return redirect()->back()->with('error', 'Error. Please try again later.');
		}

		return view('package-checkout', compact('data'));
	}

	public function delete($id) {

		//Delete any subscriptions of the package being deleted
		$subscriptions = Subscription::where('package_id', $id)->delete();

		$data = Package::find($id);
		$data->delete();

		return redirect()->route('user.packages')->with('success', 'Package deleted successfully!');
	}

	public function edit($id) {
		$data = Package::find($id);

		return view('dashboard.user.packages.edit', compact('data'));
	}

	public function update(Request $request) {
		$data = Package::find($request->id);
		$data->update([
			'name' => $request->name,
			'description' => $request->description,
			'price' => $request->price,
			'duration' => $request->duration,
		]);

		return redirect()->route('user.packages')->with('success', 'Package edited successfully!');
	}
}
