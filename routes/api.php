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
    Route::get('/attendance-history', [AttendanceApiController::class, 'history']);
    Route::get('/employee/geofences', [AttendanceApiController::class, 'getAssignedGeofences']);
    Route::get('/employee/data', [AttendanceApiController::class, 'getEmployeeData']);
});