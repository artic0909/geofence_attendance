<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Geofence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AttendanceApiController extends Controller
{
    public function checkIn(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'photo' => 'required|image|max:5120',
                'geofence_id' => 'required|exists:geofences,id',
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

            $lat = (float) $request->latitude;
            $lng = (float) $request->longitude;
            $geofenceId = $request->geofence_id;

            $geofence = Geofence::where('id', $geofenceId)
                ->where('is_active', true)
                ->first();

            if (!$geofence) {
                return response()->json([
                    'error' => 'Selected geofence is invalid or inactive',
                ], 400);
            }

            // Check if employee is inside the selected geofence
            $distance = $this->haversineDistance(
                $lat,
                $lng,
                (float) $geofence->latitude,
                (float) $geofence->longitude
            );

            Log::info("CheckIn attempt by employee {$employee->id} at ($lat, $lng) for geofence '{$geofence->name}'");
            Log::info("Distance to geofence '{$geofence->name}': {$distance}m (Radius: {$geofence->radius}m)");

            if ($distance > $geofence->radius) {
                return response()->json([
                    'error' => "You are outside the selected geofence '{$geofence->name}'.",
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
                    'geofence_id' => $geofence->id,
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
                'employee_name' => $employee->name,
                'admin_name' => $employee->admin ? $employee->admin->name : null,
                'geofence_name' => $geofence->name,
            ]);
        } catch (\Exception $e) {
            Log::error('Check-in error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function checkOut(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'photo' => 'required|image|max:5120',
                'geofence_id' => 'required|exists:geofences,id',
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

            $lat = (float) $request->latitude;
            $lng = (float) $request->longitude;
            $geofenceId = $request->geofence_id;

            $geofence = Geofence::where('id', $geofenceId)
                ->where('is_active', true)
                ->first();

            if (!$geofence) {
                return response()->json([
                    'error' => 'Selected geofence is invalid or inactive',
                ], 400);
            }

            // Check if employee is inside the selected geofence
            $distance = $this->haversineDistance(
                $lat,
                $lng,
                (float) $geofence->latitude,
                (float) $geofence->longitude
            );

            Log::info("CheckOut attempt by employee {$employee->id} at ($lat, $lng) for geofence '{$geofence->name}'");
            Log::info("Distance to geofence '{$geofence->name}': {$distance}m (Radius: {$geofence->radius}m)");

            if ($distance > $geofence->radius) {
                return response()->json([
                    'error' => "You must be within the selected geofence '{$geofence->name}' to check out.",
                ], 403);
            }

            // Save photo
            $photoPath = $request->file('photo')->store('attendance-photos', 'public');

            $attendance->update([
                'check_out' => now(),
                'check_out_lat' => $lat,
                'check_out_lng' => $lng,
                'check_out_photo' => $photoPath,
                'admin_id' => $employee->admin_id,
                'geofence_id' => $geofence->id, // update geofence
            ]);

            Log::info("CheckOut successful for employee {$employee->id}");

            return response()->json([
                'message' => 'Check-out successful!',
                'attendance' => $attendance,
                'employee_name' => $employee->name,
                'admin_name' => $employee->admin ? $employee->admin->name : null,
                'geofence_name' => $geofence->name,
            ]);
        } catch (\Exception $e) {
            Log::error('Check-out error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function history(Request $request)
    {
        try {
            $employee = $request->user();

            $attendances = Attendance::with('geofence')
                ->where('employee_id', $employee->id)
                ->orderBy('date', 'desc')
                ->get();

            $assignedGeofences = $employee->geofences()->where('is_active', true)->pluck('name');

            return response()->json([
                'employee_name' => $employee->name,
                'admin_name' => $employee->admin ? $employee->admin->name : null,
                'assigned_geofences' => $assignedGeofences,
                'attendances' => $attendances,
            ]);
        } catch (\Exception $e) {
            Log::error('History error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Calculate distance between two coordinates (in meters).
     */
    // private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    // {
    //     $earthRadius = 6371000; // meters

    //     $dLat = deg2rad($lat2 - $lat1);
    //     $dLon = deg2rad($lon2 - $lon1);

    //     $a = sin($dLat / 2) * sin($dLat / 2)
    //         + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
    //         * sin($dLon / 2) * sin($dLon / 2);

    //     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    //     return $earthRadius * $c; // meters
    // }

    public function getEmployeeData(Request $request)
    {
        $user = auth()->user();
        $employee = Employee::where('id', $user->id)->first(); // adjust according to your schema

        if (!$employee) {
            return response()->json([
                'error' => 'Employee not found'
            ], 404);
        }

        // Fetch assigned geofences if needed
        // Fetch assigned geofences as objects with id and name, convert to array
        $geofences = $user->geofences()->where('is_active', true)
            ->get(['id', 'name'])
            ->toArray(); // <-- this is key

        return response()->json([
            'employee_name' => $employee->name,
            'admin_name' => $user->admin->name ?? 'Admin', // adjust
            'assigned_geofences' => $geofences,
        ]);
    }
}
