<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\GeofenceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/privacy-policy', function () {
    return view('auth.privacy');
});

// Protected Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/export-pending', [DashboardController::class, 'exportPending'])->name('admin.dashboard.export-pending');
    Route::get('/attendances/export', [AttendanceController::class, 'export'])->name('admin.attendances.export');
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('admin.attendances');
    Route::get('/attendances/options', [AttendanceController::class, 'options'])->name('admin.attendances.options');
    Route::get('/attendances/today', [AttendanceController::class, 'todayAttedances'])->name('admin.attendances.today');
    Route::get('/attendances/today/export', [AttendanceController::class, 'todayExport'])->name('admin.attendances.today.export');
    Route::get('attendances/delete', [AttendanceController::class, 'deleteAttendances'])->name('admin.attendances.delete');
    Route::delete('attendances/bulk-delete', [AttendanceController::class, 'bulkDeleteAttendances'])->name('admin.attendances.bulk-delete');
    Route::get('/employees/{employee}/track', [EmployeeController::class, 'track'])->name('admin.employees.track');
    Route::get('/employees/{employee}/latest-location', [EmployeeController::class, 'getLatestLocation'])->name('admin.employees.latest-location');
    Route::resource('admin/employees', EmployeeController::class, ['as' => 'admin']);
    Route::resource('admin/geofences', GeofenceController::class, ['as' => 'admin']);

    // Redirect admin root to dashboard
    Route::get('/admin', function () {
        return redirect()->route('admin.dashboard');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/pricing', function () {
    return view('pages.pricing');
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
