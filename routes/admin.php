<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\GeofenceController;

// Protected Admin Routes (Organization Panel)
Route::middleware(['auth', 'subscribed'])->prefix('admin')->group(function () {
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
    Route::resource('employees', EmployeeController::class, ['as' => 'admin']);
    Route::resource('geofences', GeofenceController::class, ['as' => 'admin']);

    Route::get('/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions.index');

    // Redirect admin root to dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
});
