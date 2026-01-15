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
        return view('auth.privacy');
    });

    // Protected Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('attendances.export');
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');
        Route::get('/attendances/options', [AttendanceController::class, 'options'])->name('attendances.options');
        Route::get('/attendances/today', [AttendanceController::class, 'todayAttedances'])->name('attendances.today');
        Route::get('attendances/delete', [AttendanceController::class, 'deleteAttendances'])->name('attendances.delete');
        Route::delete('attendances/bulk-delete', [AttendanceController::class, 'bulkDeleteAttendances'])->name('attendances.bulk-delete');
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
