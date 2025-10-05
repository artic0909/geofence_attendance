<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Geofence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AttendanceApiController extends Controller
{

    public function getAssignedGeofences(Request $request)
    {
        try {
            $employee = $request->user();

            // Get assigned geofences with admin information
            $geofences = $employee->geofences()
                ->where('is_active', true)
                ->select('id', 'name', 'address', 'latitude', 'longitude', 'radius', 'admin_id')
                ->get();

            // Get admin name
            $admin = $employee->admin; // Assuming you have admin relationship in Employee model
            $adminName = $admin ? $admin->name : 'Administrator';

            return response()->json([
                'admin_name' => $adminName,
                'geofences' => $geofences,
                'employee_name' => $employee->name,
            ]);
        } catch (\Exception $e) {
            Log::error('Get assigned geofences error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch assigned geofences',
            ], 500);
        }
    }


    public function checkIn(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'photo' => 'required|image|max:5120',
            ]);

            $employee = $request->user();
            $today = now()->format('Y-m-d');

            // Check if already checked in today
            $existingAttendance = Attendance::where('employee_id', $employee->id)
                ->where('date', $today)
                ->first();

            if ($existingAttendance && $existingAttendance->check_in) {
                return response()->json([
                    'error' => 'Already checked in today',
                ], 400);
            }

            // Get assigned geofences
            $geofences = $employee->geofences()->where('is_active', true)->get();

            if ($geofences->isEmpty()) {
                return response()->json([
                    'error' => 'No geofences assigned to employee',
                ], 400);
            }

            $lat = (float) $request->latitude;
            $lng = (float) $request->longitude;
            $withinGeofence = false;
            $matchedGeofence = null;

            Log::info("CheckIn attempt by employee {$employee->id} at ($lat, $lng)");

            foreach ($geofences as $geofence) {
                $distance = $this->haversineDistance(
                    $lat,
                    $lng,
                    (float) $geofence->latitude,
                    (float) $geofence->longitude
                );

                Log::info("Distance to {$geofence->name}: {$distance}m (Radius: {$geofence->radius}m)");

                if ($distance <= $geofence->radius) {
                    $withinGeofence = true;
                    $matchedGeofence = $geofence;
                    Log::info("Employee {$employee->id} is INSIDE geofence '{$geofence->name}'");
                    break;
                }
            }

            if (!$withinGeofence) {
                Log::warning("Employee {$employee->id} is OUTSIDE all geofences");
                return response()->json([
                    'error' => 'You are not within any assigned geofence area. Current location is too far from your assigned geofences.',
                ], 403);
            }

            // Save photo
            $photoPath = $request->file('photo')->store('attendance-photos', 'public');

            // Create attendance record
            $attendance = Attendance::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'date' => $today,
                ],
                [
                    'admin_id' => $employee->admin_id,
                    'geofence_id' => $matchedGeofence->id,
                    'check_in' => now(),
                    'check_in_lat' => $lat,
                    'check_in_lng' => $lng,
                    'check_in_photo' => $photoPath,
                ]
            );

            Log::info("CheckIn successful for employee {$employee->id}");

            return response()->json([
                'message' => 'Check-in successful!',
                'attendance' => $attendance,
                'geofence' => $matchedGeofence->name
            ]);
        } catch (\Exception $e) {
            Log::error('Check-in error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Calculate distance between two coordinates (in meters).
     */
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // meters
    }

    public function checkOut(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'photo' => 'required|image|max:5120',
            ]);

            $employee = $request->user();
            $today = now()->format('Y-m-d');

            $attendance = Attendance::where('employee_id', $employee->id)
                ->where('date', $today)
                ->first();

            if (!$attendance || !$attendance->check_in) {
                return response()->json([
                    'error' => 'No check-in found for today',
                ], 400);
            }

            if ($attendance->check_out) {
                return response()->json([
                    'error' => 'Already checked out today',
                ], 400);
            }

            // Get the geofence where the employee checked in
            $checkInGeofence = Geofence::find($attendance->geofence_id);

            if (!$checkInGeofence) {
                return response()->json([
                    'error' => 'Unable to find your check-in location data',
                ], 400);
            }

            $lat = (float) $request->latitude;
            $lng = (float) $request->longitude;

            Log::info("CheckOut attempt by employee {$employee->id} at ($lat, $lng)");
            Log::info("Check-in was at geofence: {$checkInGeofence->name}");

            // Check if employee is within the same geofence where they checked in
            $distance = $this->haversineDistance(
                $lat,
                $lng,
                (float) $checkInGeofence->latitude,
                (float) $checkInGeofence->longitude
            );

            Log::info("Distance to check-in geofence '{$checkInGeofence->name}': {$distance}m (Radius: {$checkInGeofence->radius}m)");

            if ($distance > $checkInGeofence->radius) {
                Log::warning("Employee {$employee->id} is OUTSIDE check-in geofence for checkout");
                return response()->json([
                    'error' => 'You must be within the same location where you checked in to check out. Current location is too far from your check-in location.',
                ], 403);
            }

            Log::info("Employee {$employee->id} is INSIDE check-in geofence for checkout");

            // Save photo
            $photoPath = $request->file('photo')->store('attendance-photos', 'public');

            $attendance->update([
                'check_out' => now(),
                'check_out_lat' => $request->latitude,
                'check_out_lng' => $request->longitude,
                'check_out_photo' => $photoPath,
                'admin_id' => $employee->admin_id,
            ]);

            Log::info("CheckOut successful for employee {$employee->id}");

            return response()->json([
                'message' => 'Check-out successful!',
                'attendance' => $attendance,
                'geofence' => $checkInGeofence->name
            ]);
        } catch (\Exception $e) {
            Log::error('Check-out error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function history(Request $request)
    {
        try {
            $employee = $request->user();

            $attendances = Attendance::with('geofence')
                ->where('employee_id', $employee->id)
                ->orderBy('date', 'desc')
                ->get();

            return response()->json(['attendances' => $attendances]);
        } catch (\Exception $e) {
            Log::error('History error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
