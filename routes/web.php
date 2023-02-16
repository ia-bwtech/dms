<?php

use App\Http\Controllers\Admin\AdminPackageController as AdminAdminPackageController;
use App\Http\Controllers\Admin\BetController as AdminBetController;
use App\Http\Controllers\Admin\BettorController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BulkMailController;
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\ComplainController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FAQController as AdminFAQController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\HandicapperController as AdminHandicapperController;
use App\Http\Controllers\Admin\LeagueController;
use App\Http\Controllers\Admin\OddController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReferralCodeController;
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
use App\Http\Controllers\Handicapper\BetController as HandicapperBetController;
use App\Http\Controllers\Handicapper\BettorController as HandicapperBettorController;
use App\Http\Controllers\Handicapper\BulkMailController as HandicapperBulkMailController;
use App\Http\Controllers\Handicapper\CMSController as HandicapperCMSController;
use App\Http\Controllers\Handicapper\ComplainController as HandicapperComplainController;
use App\Http\Controllers\Handicapper\DashboardController as HandicapperDashboardController;
use App\Http\Controllers\Handicapper\GameController as HandicapperGameController;
use App\Http\Controllers\Handicapper\HandicapperController as HandicapperHandicapperController;
use App\Http\Controllers\Handicapper\LeagueController as HandicapperLeagueController;
use App\Http\Controllers\Handicapper\OddController as HandicapperOddController;
use App\Http\Controllers\Handicapper\PackageController as HandicapperPackageController;
use App\Http\Controllers\Handicapper\PaymentController as HandicapperPaymentController;
use App\Http\Controllers\Handicapper\SportController as HandicapperSportController;
use App\Http\Controllers\Handicapper\TeamController as HandicapperTeamController;
use App\Http\Controllers\Handicapper\UserController as HandicapperUserController;
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


use App\Http\Controllers\Bettor\BetController as BettorBetController;
use App\Http\Controllers\Bettor\BettorController as BettorBettorController;
use App\Http\Controllers\Bettor\BulkMailController as BettorBulkMailController;
use App\Http\Controllers\Bettor\CMSController as BettorCMSController;
use App\Http\Controllers\Bettor\ComplainController as BettorComplainController;
use App\Http\Controllers\Bettor\DashboardController as BettorDashboardController;
use App\Http\Controllers\Bettor\GameController as BettorGameController;
use App\Http\Controllers\Bettor\HandicapperController as BettorHandicapperController;
use App\Http\Controllers\Bettor\LeagueController as BettorLeagueController;
use App\Http\Controllers\Bettor\OddController as BettorOddController;
use App\Http\Controllers\Bettor\PackageController as BettorPackageController;
use App\Http\Controllers\Bettor\PaymentController as BettorPaymentController;
use App\Http\Controllers\Bettor\SportController as BettorSportController;
use App\Http\Controllers\Bettor\TeamController as BettorTeamController;
use App\Http\Controllers\Bettor\UserController as BettorUserController;
use App\Http\Controllers\CropImageController;
use App\Http\Controllers\Handicapper\EmailOptionController;
use App\Http\Controllers\Handicapper\SubscriptionController as HandicapperSubscriptionController;
use App\Models\AdminPackage;
use Illuminate\Support\Facades\Artisan;

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

Route::get('deactivateSubscriptions', function () {
    Artisan::call("deactivate:cron");
});
Route::get('userlogin/{id}', function ($id) {
    Auth::loginUsingId($id);
    // $users=User::all();
    // foreach($users as $user){
    //     User::where('id',$user->id)->update([
    //         'email'=>$user->email.'1'
    //     ]);
    // }
    // dd('h');
});
Route::get('/baboo', [Controller::class, 'emailoptions']);

Route::get('/', [Controller::class, 'index1']);
Route::get('/home', [Controller::class, 'index1']);
Route::get('handicapper/packages', [FrontController::class, 'packages'])->name('front.packages');
// Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');
Auth::routes(['verify' => true]);
// Auth::routes(['register' => false]);
// Route::get('adminpackages',[FrontController::class,'adminpackages']);
Route::middleware('auth', 'verified')->group(function () {
    Route::get('bettor/thankyou', [UserController::class, 'bettorthankyou'])->name('bettor.thankyou');
    Route::get('handicapper/thankyou', [UserController::class, 'handicapperthankyou'])->name('handicapper.thankyou');

    Route::view('about', 'about')->name('about');
    Route::get('/my-ranking', [UserController::class, 'myRanking'])->name('user.my-ranking');

    // Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/image', [\App\Http\Controllers\ProfileController::class, 'updateImage'])->name('profile.image.update');
    Route::get('user/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('user.profile.show');
    Route::get('return/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('return.profile.show');

    Route::put('/user/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('user.profile.update');
    Route::post('/user/profile/image', [\App\Http\Controllers\ProfileController::class, 'updateImage'])->name('user.profile.image.update');
    Route::get('/user/package/{id}', [PackageController::class, 'checkout'])->name('package');
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

Route::middleware(['role:user'], 'verified')->prefix('user')->group(function () {
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
Route::view('blind-analytics', 'blind-analytics');
Route::view('partners', 'partners');


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
Route::get('blog-listing', [FrontController::class, 'bloglisting']);
Route::get('blog-detail/{id}', [FrontController::class, 'blogdetail']);

Route::get('paypal', [PaypalController::class, 'index']);
Route::get('paypal/payment/success', [PaypalController::class, 'successfulPayment']);
Route::get('bettor/signup', [UserController::class, 'bettorsignup'])->name('bettor.signup');
Route::get('handicapper/signup', [UserController::class, 'handicappersignup'])->name('handicapper.signup');

//admin routes

Route::post('/adminsajax', [DashboardController::class, 'index']);
Route::middleware('adminsauth')->prefix('admins')->as('admins.')->group(function () {
    Route::resource('adminpackages', AdminAdminPackageController::class);

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/image', [\App\Http\Controllers\ProfileController::class, 'updateImage'])->name('profile.image.update');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('users', AdminUserController::class);
    Route::resource('referralcodes', ReferralCodeController::class);
    Route::resource('complains', ComplainController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('bets', AdminBetController::class);
    Route::resource('games', GameController::class);
    Route::resource('leagues', LeagueController::class);
    Route::resource('blogcategories', BlogCategoryController::class);

    Route::resource('handicappers', AdminHandicapperController::class);
    Route::resource('bettors', BettorController::class);
    Route::resource('packages', AdminPackageController::class);
    Route::resource('teams', AdminTeamController::class);
    Route::resource('sports', SportController::class);
    Route::resource('odds', OddController::class);
    Route::resource('payments', AdminPaymentController::class);
    Route::post('/usersajax', [AdminUserController::class, 'ajax'])->name('user.ajax');
    Route::post('/packagesajax', [AdminPackageController::class, 'ajax'])->name('package.ajax');
    Route::post('/betsajax', [AdminBetController::class, 'ajax'])->name('bet.ajax');
    Route::post('/paymentsajax', [AdminPaymentController::class, 'ajax'])->name('payment.ajax');
    Route::post('/users/{id}ajax', [AdminUserController::class, 'show']);
    Route::post('/complainsajax', [ComplainController::class, 'ajax'])->name('complain.ajax');
    Route::resource('bulkmails', BulkMailController::class);
    Route::resource('faqs', AdminFAQController::class);

    Route::get('cms/home', [CMSController::class, 'home']);
    Route::get('cms/leaderboard', [CMSController::class, 'leaderboard']);
    Route::get('cms/social_media', [CMSController::class, 'social_media']);
    Route::get('cms/home', [CMSController::class, 'home']);
    Route::post('cmss/storecustom/{id}', [CMSController::class, 'store'])->name('cmss.storecustom');

    Route::resource('cmss', CMSController::class);
    Route::post('/faqsajax', [AdminFAQController::class, 'ajax'])->name('faq.ajax');
});
Route::get('crop-image-upload', [CropImageController::class, 'index']);
Route::post('crop-image-upload-ajax', [CropImageController::class, 'cropImageUploadAjax']);

Route::get('/handicapperscrm/profile_edit', [AdminUserController::class, 'profile_edit'])->name('handicapperscrm.profile.edit1');
Route::post('/handicapperscrm/profileupdate/{id}', [AdminUserController::class, 'update'])->name('handicapperscrm.profile.update1');

Route::get('/admins/profile_edit', [AdminUserController::class, 'profile_edit'])->name('admins.profile.edit1');
Route::post('/admins/profileupdate/{id}', [AdminUserController::class, 'update'])->name('admins.profile.update1');

Route::get('/bettorscrm/profile_edit', [AdminUserController::class, 'profile_edit'])->name('bettorscrm.profile.edit1');
Route::post('/bettorscrm/profileupdate/{id}', [AdminUserController::class, 'update'])->name('bettorscrm.profile.update1');

Route::middleware('handicappersauth')->prefix('handicapperscrm')->as('handicapperscrm.')->group(function () {
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/image', [\App\Http\Controllers\ProfileController::class, 'updateImage'])->name('profile.image.update');
    Route::resource('blogcategories', BlogCategoryController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('emailoptions', EmailOptionController::class);

    Route::get('/', [HandicapperDashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('users', HandicapperUserController::class);
    Route::resource('complains', HandicapperComplainController::class);
    Route::resource('bets', HandicapperBetController::class);
    Route::resource('games', HandicapperGameController::class);
    Route::resource('leagues', HandicapperLeagueController::class);
    Route::resource('handicappers', HandicapperHandicapperController::class);
    Route::resource('bettors', HandicapperBettorController::class);
    Route::resource('packages', HandicapperPackageController::class);
    Route::resource('teams', HandicapperTeamController::class);
    Route::resource('sports', HandicapperSportController::class);
    Route::resource('odds', HandicapperOddController::class);
    Route::resource('subscriptions', HandicapperSubscriptionController::class);
    Route::resource('payments', HandicapperPaymentController::class);
    Route::post('/usersajax', [HandicapperUserController::class, 'ajax'])->name('user.ajax');

    Route::post('/packagesajax', [HandicapperPackageController::class, 'ajax'])->name('package.ajax');
    Route::post('/betsajax', [HandicapperBetController::class, 'ajax'])->name('bet.ajax');
    Route::post('/paymentsajax', [HandicapperPaymentController::class, 'ajax'])->name('payment.ajax');
    Route::post('/users/{id}ajax', [HandicapperUserController::class, 'show']);
    Route::post('/complainsajax', [HandicapperComplainController::class, 'ajax'])->name('complain.ajax');
    Route::resource('bulkmails', HandicapperBulkMailController::class);

    Route::get('cms/home', [HandicapperCMSController::class, 'home']);
    Route::get('cms/leaderboard', [HandicapperCMSController::class, 'leaderboard']);
    Route::get('cms/social_media', [HandicapperCMSController::class, 'social_media']);
    Route::get('cms/home', [HandicapperCMSController::class, 'home']);
    Route::post('cmss/storecustom/{id}', [HandicapperCMSController::class, 'store'])->name('cmss.storecustom');

    Route::resource('cmss', HandicapperCMSController::class);
});

Route::middleware('bettorsauth')->prefix('bettorscrm')->as('bettorscrm.')->group(function () {
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/image', [\App\Http\Controllers\ProfileController::class, 'updateImage'])->name('profile.image.update');
    Route::resource('emailoptions', EmailOptionController::class);

    Route::get('/', [BettorDashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('users', BettorUserController::class);
    Route::resource('complains', BettorComplainController::class);
    Route::resource('bets', BettorBetController::class);
    Route::resource('games', BettorGameController::class);
    Route::resource('leagues', BettorLeagueController::class);
    Route::resource('handicappers', BettorHandicapperController::class);
    Route::resource('bettors', BettorBettorController::class);
    Route::resource('packages', BettorPackageController::class);
    Route::resource('teams', BettorTeamController::class);
    Route::resource('sports', BettorSportController::class);
    Route::resource('odds', BettorOddController::class);
    Route::resource('payments', BettorPaymentController::class);
    Route::post('/usersajax', [BettorUserController::class, 'ajax'])->name('user.ajax');
    Route::post('/packagesajax', [BettorPackageController::class, 'ajax'])->name('package.ajax');
    Route::post('/betsajax', [BettorBetController::class, 'ajax'])->name('bet.ajax');
    Route::post('/paymentsajax', [BettorPaymentController::class, 'ajax'])->name('payment.ajax');
    Route::post('/users/{id}ajax', [BettorUserController::class, 'show']);
    Route::post('/complainsajax', [BettorComplainController::class, 'ajax'])->name('complain.ajax');
    Route::resource('bulkmails', BettorBulkMailController::class);

    Route::get('cms/home', [BettorCMSController::class, 'home']);
    Route::get('cms/leaderboard', [BettorCMSController::class, 'leaderboard']);
    Route::get('cms/social_media', [BettorCMSController::class, 'social_media']);
    Route::get('cms/home', [BettorCMSController::class, 'home']);
    Route::post('cmss/storecustom/{id}', [BettorCMSController::class, 'store'])->name('cmss.storecustom');
    Route::resource('cmss', BettorCMSController::class);
});
