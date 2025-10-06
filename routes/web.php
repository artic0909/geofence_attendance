<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\GeofenceController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use Illuminate\Support\Facades\Route;

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login Routes
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::get('/privacy-policy', function () {
        return redirect()->route('auth.privacy');
    });

    // Protected Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');
        Route::resource('employees', EmployeeController::class);
        Route::resource('geofences', GeofenceController::class);

        // Redirect admin root to dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
    });
});

// Redirect root to admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});
