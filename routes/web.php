<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Superadmin\AuthController as SuperadminAuthController;
use App\Http\Controllers\Superadmin\PlanController;

// Superadmin Routes
Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/login', [SuperadminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SuperadminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [SuperadminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('plans', PlanController::class)->except(['show']);
        Route::resource('organizations', \App\Http\Controllers\Superadmin\OrganizationController::class);
        Route::resource('subscriptions', \App\Http\Controllers\Superadmin\SubscriptionController::class);
        
        Route::get('settings', [\App\Http\Controllers\Superadmin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Superadmin\SettingController::class, 'update'])->name('settings.update');
    });
});

// Auth Routes
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
});

Route::get('/terms', function () {
    return view('pages.terms');
});

Route::get('/privacy-policy', function () {
    return view('pages.privacy');
});

Route::get('/industries', function () {
    return view('pages.industries');
});

Route::get('/contact', function () {
    return view('pages.contact');
});
