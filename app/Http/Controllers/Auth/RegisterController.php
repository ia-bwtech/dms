<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\NewRegistration;
use App\Mail\RegistrationAlert;
use Illuminate\Support\Facades\App;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo;

    public function redirectTo()
    {

        if (auth()->user()->hasRole('admin')) {
            $this->redirectTo = '/admin/dashboard';
            return $this->redirectTo;
        } else if (auth()->user()->is_handicapper == 1) {
            $this->redirectTo = '/handicapper/thankyou';
            return $this->redirectTo;
        } else if (auth()->user()->is_handicapper == 0) {
            $this->redirectTo = '/bettor/thankyou';
            return $this->redirectTo;
        }

        $this->redirectTo = '/';
        return $this->redirectTo;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'referral_code' => ['nullable', 'exists:referral_codes,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // dd(public_path('images/profile'));
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'referral_code' => $data['referral_code'],
            'password' => Hash::make($data['password']),
            'is_handicapper' => $data['is_handicapper']
        ]);
        $this->addAdminPackage();
        $this->emailoptions();

        if (request()->hasFile('image')) {
            $imageName = $user->id . '-' . $user->name . '-' . request()->file('image')->getClientOriginalName();
            $path = public_path('images/profile');
            request()->file('image')->move($path, $imageName);
            $user->update(['image' => $imageName]);
        }

        $user->assignRole('user');
        // $user->is_handicapper = 1;
        $user->payment_cut_percentage = 50;

        //Email to new registered user
        // try {
        Mail::to(User::find($user->id))->send(new NewRegistration());
        $data = [
            'user_email' => $user->email,
            'name' => $user->name,
            'subject' => 'New User Registered',
            'referral_code' => $user->referral_code
        ];
        Mail::to('blindsidebets@demo-customweb.com')->send(new RegistrationAlert($data));

        // } catch (\Throwable $th) {
        // Log::error($th);
        // }

        if (App::environment('local')) {
            $stripeKey = config('values.stripe_test');
        } else if (App::environment('production')) {
            $stripeKey = config('values.stripe_live');
        }

        $stripe = new \Stripe\StripeClient($stripeKey);

        $connectedAccount = $stripe->accounts->create(['type' => 'express']);
        $user->stripe_id = $connectedAccount->id;
        $user->save();

        return $user;
    }
}
