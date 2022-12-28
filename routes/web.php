<?php

use App\Http\Controllers\Admin\BetController as AdminBetController;
use App\Http\Controllers\Admin\BettorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\HandicapperController as AdminHandicapperController;
use App\Http\Controllers\Admin\LeagueController;
use App\Http\Controllers\Admin\OddController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\SportController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Bet;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HandicapperController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PackageSubscribed;
use App\Mail\NewPackageSubscriber;
use App\Mail\NewRegistration;
use App\Mail\SubscribedBetPlaced;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Controller::class, 'index1']);
Route::get('/home', [Controller::class, 'index1']);
Route::get('handicapper/packages',[FrontController::class,'packages'])->name('front.packages');
// Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');
Auth::routes(['verify'=>true]);
// Auth::routes(['register' => false]);

Route::middleware('auth','verified')->group(function () {
    Route::get('bettor/thankyou',[UserController::class,'bettorthankyou'])->name('bettor.thankyou');
    Route::get('handicapper/thankyou',[UserController::class,'handicapperthankyou'])->name('handicapper.thankyou');

    Route::view('about', 'about')->name('about');
    Route::get('/my-ranking', [UserController::class, 'myRanking'])->name('user.my-ranking');

    // Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/image', [\App\Http\Controllers\ProfileController::class, 'updateImage'])->name('profile.image.update');

    Route::get('package/{id}', [PackageController::class, 'checkout'])->name('package');
});

Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/handicappers', [AdminController::class, 'handicappers'])->name('admin.handicappers');
    Route::get('/user/{id}/verify', [AdminController::class, 'verifyUser'])->name('admin.user.verify');
    Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::post('featured/update', [AdminController::class, 'updateFeatured'])->name('featured.update');

    //FAQ
    Route::get('/faq/create', [FAQController::class, 'create'])->name('faq.create');
    Route::post('/faq/store', [FAQController::class, 'store'])->name('faq.store');
    Route::get('/faq/index', [FAQController::class, 'index'])->name('faqs');
    Route::get('/faq/{id}/edit', [FAQController::class, 'edit'])->name('faq.edit');
    Route::put('/faq/update', [FAQController::class, 'update'])->name('faq.update');
    Route::get('/faq/{id}/delete', [FAQController::class, 'delete'])->name('faq.delete');

    //Bets
    Route::get('/bets', [BetController::class, 'allBets'])->name('admin.bets');
    Route::get('/bets/filter', [BetController::class, 'filterBets'])->name('admin.bets.filter');
});

Route::middleware(['role:user'],'verified')->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    //Packages
    Route::get('/packages', [PackageController::class, 'index'])->name('user.packages');
    Route::get('/package/{id}/edit', [PackageController::class, 'edit'])->name('package.edit');
    Route::put('/package/update', [PackageController::class, 'update'])->name('package.update');
    Route::get('/package/{id}/delete', [PackageController::class, 'delete'])->name('package.delete');
    Route::get('/package/create', [PackageController::class, 'create'])->name('package.create');
    Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');

    //Bets
    Route::get('/bets', [BetController::class, 'userBets'])->name('user.bets');

    //Subscribers
    Route::get('/subscribers', [SubscriptionController::class, 'index'])->name('user.subscribers');

    //Payments
    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'index'])->name('user.payments');
});

//Pages
Route::view('packages', 'package');
Route::get('leaderboard', [HandicapperController::class, 'leaderboard'])->name('handicappers.leaderboard');
Route::get('handicappers/{id}', [HandicapperController::class, 'profile'])->name('handicappers.profile');
Route::get('top50', [Controller::class, 'top50']);
Route::view('/terms', 'terms');
Route::view('/forum', 'forum');
Route::get('historical-records', [HandicapperController::class, 'historicalRecords'])->name('historical.records');
Route::view('/socials', 'social');
Route::view('/tournaments', 'tournament');
Route::get('/faq', [FAQController::class, 'show'])->name('faqs.index');
Route::get('/team/logos', [TeamController::class, 'index']);

//Payments
Route::get('stripe/connect', [PaymentController::class, 'stripeConnect']);
Route::get('return', [PaymentController::class, 'stripeConnectReturnResponse']);
Route::get('refresh', function () {
    return redirect('/stripe/connect');
});
Route::get('payment-success', [PaymentController::class, 'paymentSuccess']);

Route::get('mail', function () {
    $data = Bet::find(3);

    return new App\Mail\SubscribedBetPlaced($data);
});

Route::get('test', [Controller::class, 'test']);

Route::get('paypal', [PaypalController::class, 'index']);
Route::get('paypal/payment/success', [PaypalController::class, 'successfulPayment']);
Route::get('bettor/signup',[UserController::class,'bettorsignup'])->name('bettor.signup');
Route::get('handicapper/signup',[UserController::class,'handicappersignup'])->name('handicapper.signup');

//admin routes

Route::middleware('auth')->prefix('admins')->as('admins.')->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('dashboard.index');
    Route::resource('users',AdminUserController::class);
    Route::resource('bets',AdminBetController::class);
    Route::resource('games',GameController::class);
    Route::resource('leagues',LeagueController::class);
    Route::resource('handicappers',AdminHandicapperController::class);
    Route::resource('bettors',BettorController::class);
    Route::resource('packages',AdminPackageController::class);
    Route::resource('teams',AdminTeamController::class);
    Route::resource('sports',SportController::class);
    Route::resource('odds',OddController::class);
    Route::resource('payments',AdminPaymentController::class);
    Route::post('/usersajax', [AdminUserController::class, 'ajax'])->name('user.ajax');
    Route::post('/packagesajax', [AdminPackageController::class, 'ajax'])->name('package.ajax');
    Route::post('/betsajax', [AdminBetController::class, 'ajax'])->name('bet.ajax');
    Route::post('/paymentsajax', [AdminPaymentController::class, 'ajax'])->name('payment.ajax');
    Route::post('/users/{id}ajax', [AdminUserController::class, 'show']);



});
