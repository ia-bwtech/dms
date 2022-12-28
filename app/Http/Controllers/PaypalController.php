<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PackageSubscribed;
use App\Mail\NewPackageSubscriber;

class PaypalController extends Controller
{
    public function index() {
        $provider = new PayPalClient;

        $provider = \PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $templates = $provider->listInvoiceTemplates();
        return $templates;
    }

    public function successfulPayment() {
        $data = json_decode(request()->data);
        
        $payment = Payment::create([
            'user_id' => auth()->user()->id,
            'package_id' => $data->purchase_units[0]->description,
            'charge_id' => $data->purchase_units[0]->payments->captures[0]->id,
            'amount' => $data->purchase_units[0]->payments->captures[0]->amount->value,
            'status' => $data->status,
        ]); 
            
        $subscription = Subscription::create([
            'user_id' => auth()->user()->id,
            'package_id' => $data->purchase_units[0]->description,
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
    
        return redirect()->route('user.packages')->with('success', 'Payment successful!');
    }
}
