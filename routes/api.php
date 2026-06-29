<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/check-in', [AttendanceApiController::class, 'checkIn']);
    Route::post('/check-out', [AttendanceApiController::class, 'checkOut']);
    Route::post('/outside-check-in', [AttendanceApiController::class, 'outsideCheckIn']);
    Route::post('/outside-check-out', [AttendanceApiController::class, 'outsideCheckOut']);
    Route::get('/attendance-history', [AttendanceApiController::class, 'history']);
    Route::get('/employee/geofences', [AttendanceApiController::class, 'getAssignedGeofences']);
    Route::get('/employee/data', [AttendanceApiController::class, 'getEmployeeData']);
    Route::post('/location-update', [AttendanceApiController::class, 'updateLocation']);

    // Admin Routes
    Route::get('/admin/dashboard', [App\Http\Controllers\Api\AdminApiController::class, 'dashboard']);
    Route::get('/admin/today-present', [App\Http\Controllers\Api\AdminApiController::class, 'todayPresent']);
    Route::get('/admin/today-absent', [App\Http\Controllers\Api\AdminApiController::class, 'todayAbsent']);
    Route::get('/admin/track/{employee_id}', [App\Http\Controllers\Api\AdminApiController::class, 'trackEmployee']);
    Route::get('/admin/settings', [App\Http\Controllers\Api\AdminApiController::class, 'getSettings']);
    Route::post('/admin/settings', [App\Http\Controllers\Api\AdminApiController::class, 'updateSettings']);
});

// routes/api.php
Route::middleware('auth:sanctum')->get('/employee-data', [AttendanceApiController::class, 'getEmployeeData']);
