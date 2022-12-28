<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PackageSubscribed;
use App\Mail\NewPackageSubscriber;
use App\Mail\NewRegistration;
use Illuminate\Support\Facades\App;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->stripe_id == null) {
            return view('dashboard.user.payments.index');
        }

        if (App::environment('local')) {
			$stripeKey = config('values.stripe_test');
		}
		else if(App::environment('production')) {
			$stripeKey = config('values.stripe_live');
		}
        
        $stripe = new \Stripe\StripeClient(
            $stripeKey
        );
    
        $account = $stripe->accounts->retrieve(
            auth()->user()->stripe_id,
        []
        );
    
        return view('dashboard.user.payments.index', compact('account'));
    }

    public function stripeConnect() {
        
        if (App::environment('local')) {
			$stripeKey = config('values.stripe_test');
		}
		else if(App::environment('production')) {
			$stripeKey = config('values.stripe_live');
		}
        
        $stripe = new \Stripe\StripeClient($stripeKey);

        if(auth()->user()->stripe_id == null) {
            $connectedAccount = $stripe->accounts->create(['type' => 'express']);
            // return $connectedAccount;

            auth()->user()->stripe_id = $connectedAccount->id;
            auth()->user()->save();
        }

        $createAccountLink = $stripe->accountLinks->create([
            'account' => auth()->user()->stripe_id,
            'refresh_url' => url('/') .  '/refresh',
            'return_url' => url('/') .  '/return',
            'type' => 'account_onboarding',
            ]
        );

        return redirect($createAccountLink->url);
    }

    public function stripeConnectReturnResponse() {
        
        if (App::environment('local')) {
			$stripeKey = config('values.stripe_test');
		}
		else if(App::environment('production')) {
			$stripeKey = config('values.stripe_live');
		}
        
        $stripe = new \Stripe\StripeClient(
            $stripeKey
        );
    
        $account = $stripe->accounts->retrieve(
            // 'acct_1LW6rYGhktYPopXv',
            auth()->user()->stripe_id,
        []
        );
        // return $account;
    
        if($account->details_submitted == 1) {
            auth()->user()->stripe_connected = 1;
            auth()->user()->save();
        }
    
        return view('auth.profile', compact('account'));
    }

    public function paymentSuccess() {
        if (App::environment('local')) {
			$stripeKey = config('values.stripe_test');
		}
		else if(App::environment('production')) {
			$stripeKey = config('values.stripe_live');
		}
        
        $stripe = new \Stripe\StripeClient(
            $stripeKey
        );
    
        $data = $stripe->paymentIntents->retrieve(
            request()->input('payment_intent'),
            []
        );
    
        // if($data->status == 'succeeded') {
            $payment = Payment::create([
                'user_id' => auth()->user()->id,
                'package_id' => $data->charges->data[0]->description,
                'charge_id' => $data->charges->data[0]->id,
                'amount' => $data->charges->data[0]->amount_captured,
                'status' => $data->charges->data[0]->status,
            ]);

            
            
            $subscription = Subscription::create([
                'user_id' => auth()->user()->id,
                'package_id' => $data->charges->data[0]->description,
                'package_owner_id' => $payment->package->user->id,
                'payment_id' => $payment->id,
                'status' => 1,
            ]);
    
            if($payment) {
                //Email to package subscriber
                try {
                    Mail::to(User::find(auth()->user()->id))->send(new PackageSubscribed($payment));
                } catch (\Throwable $th) {
                    Log::error($th);
                }
    
                //Email to package creator
                try {
                    Mail::to(User::find($payment->package->user_id))->send(new NewPackageSubscriber($payment));
                } catch (\Throwable $th) {
                    Log::error($th);
                }
            }
        // }
    
        return redirect()->route('user.packages')->with('success', 'Payment successful!');
        // return redirect()->back()->with('success', 'Profile updated.');
    }
}
