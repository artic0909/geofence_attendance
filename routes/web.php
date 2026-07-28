<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Superadmin\AuthController as SuperadminAuthController;
use App\Http\Controllers\Superadmin\PlanController;
use App\Http\Controllers\Superadmin\CouponController;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/generate-sitemap', function () {

    Sitemap::create()

        ->add(
            Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        )

        ->add(
            Url::create('/about')
                ->setPriority(0.8)
        )

        ->add(
            Url::create('/pricing')
                ->setPriority(0.9)
        )

        ->add(
            Url::create('/industries')
                ->setPriority(0.8)
        )

        ->add(
            Url::create('/contact')
                ->setPriority(0.8)
        )

        ->add(
            Url::create('/privacy-policy')
        )

        ->add(
            Url::create('/terms')
        )

        ->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap generated successfully!';
});

// Superadmin Routes
Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/login', [SuperadminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SuperadminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [SuperadminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('plans', PlanController::class)->except(['show']);
        
        Route::get('organizations/need-inform', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'needInform'])->name('organizations.need-inform');
        Route::get('organizations/expired', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'expired'])->name('organizations.expired');
        Route::resource('organizations', \App\Http\Controllers\Superadmin\OrganizationController::class);
        Route::get('organizations/{organization}/employees/{employee}/track', [\App\Http\Controllers\Superadmin\OrganizationEmployeeController::class, 'track'])->name('organizations.employees.track');
        Route::get('organizations/{organization}/employees/{employee}/latest-location', [\App\Http\Controllers\Superadmin\OrganizationEmployeeController::class, 'latestLocation'])->name('organizations.employees.latest-location');
        Route::resource('organizations.employees', \App\Http\Controllers\Superadmin\OrganizationEmployeeController::class);
        Route::resource('organizations.geofences', \App\Http\Controllers\Superadmin\OrganizationGeofenceController::class);
        Route::post('organizations/{organization}/apply-coupon', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'applyCoupon'])->name('organizations.apply-coupon');
        Route::resource('subscriptions', \App\Http\Controllers\Superadmin\SubscriptionController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource('contacts', \App\Http\Controllers\Superadmin\ContactController::class)->only(['index', 'show', 'destroy']);
        
        Route::get('settings', [\App\Http\Controllers\Superadmin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Superadmin\SettingController::class, 'update'])->name('settings.update');
    });
});

// Auth Routes
Route::get("/password/reset", [App\Http\Controllers\Auth\ForgotPasswordController::class, "showLinkRequestForm"])->name("password.request");
Route::post("/password/email", [App\Http\Controllers\Auth\ForgotPasswordController::class, "sendOtp"])->name("password.email");
Route::post("/password/verify-otp", [App\Http\Controllers\Auth\ForgotPasswordController::class, "verifyOtp"])->name("password.verify");
Route::post("/password/reset", [App\Http\Controllers\Auth\ForgotPasswordController::class, "resetPassword"])->name("password.update");
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/privacy-policy', function () {
    return view('auth.privacy');
});

// Subscription Flow
Route::middleware(['auth'])->group(function () {
    Route::get('/pricing/select', [SubscriptionController::class, 'selectPlan'])->name('pricing.select');
    Route::post('/pricing/checkout', [SubscriptionController::class, 'createOrder'])->name('pricing.checkout');
    Route::post('/pricing/verify', [SubscriptionController::class, 'verifyPayment'])->name('pricing.verify');
});



use App\Models\Plan;

Route::get('/', function () {
    $plans = Plan::where('active', true)->get();
    return view('welcome', compact('plans'));
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/pricing', function () {
    $plans = Plan::where('active', true)->get();
    return view('pages.pricing', compact('plans'));
})->name('pricing');

Route::get('/terms', function () {
    return view('pages.terms');
});

Route::get('/privacy-policy', function () {
    return view('pages.privacy');
});

Route::get('/industries', function () {
    return view('pages.industries');
});

Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
