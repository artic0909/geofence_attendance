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
            ]);

            $employee = $request->user();
            $admin = $employee->admin;
            $isExpired = $admin->subscription_expires_at && now()->greaterThan($admin->subscription_expires_at);

            if ($admin->subscription_status !== 'active' || $isExpired) {
                return response()->json([
                    'error' => 'Your organization\'s subscription has expired. Attendance is disabled.',
                ], 403);
            }

            $time = $request->filled('timestamp') ? \Carbon\Carbon::parse($request->timestamp) : now();
            $today = $time->format('Y-m-d');

            // Check if already checked in (active session within last 24h not yet checked out)
            $activeAttendance = $this->getActiveAttendance($employee->id);
            $activeOutside = $this->getActiveOutsideAttendance($employee->id);

            if ($activeAttendance || $activeOutside) {
                return response()->json([
                    'error' => 'You are already checked in. Please check out first.',
                ], 400);
            }

            // Get assigned geofences
            $geofences = $employee->employeeGeofences()->where('is_active', true)->get();

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
            $attendance = Attendance::create([
                'employee_id' => $employee->id,
                'admin_id' => $employee->admin_id,
                'geofence_id' => $matchedGeofence->id,
                'date' => $today,
                'check_in' => $time,
                'check_in_lat' => $lat,
                'check_in_lng' => $lng,
                'check_in_photo' => $photoPath,
                'status' => 'present',
            ]);

            Log::info("CheckIn successful for employee {$employee->id}");

            return response()->json([
                'message' => 'Check-in successful!',
                'attendance' => $attendance,
                'employee_name' => $employee->name,
                'admin_name' => $employee->admin ? ($employee->admin->business_name ?? $employee->admin->name) : null,
                'geofence_name' => $matchedGeofence->name,
                'assigned_geofences' => $geofences->pluck('name'), // all geofences for this employee
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors(),
            ], 422);
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
                'photo' => $request->boolean('is_auto_trap') ? 'nullable|image|max:5120' : 'required|image|max:5120',
            ]);

            $employee = $request->user();
            $time = $request->filled('timestamp') ? \Carbon\Carbon::parse($request->timestamp) : now();

            // Find active check-in within the last 24 hours
            $attendance = $this->getActiveAttendance($employee->id);

            if (!$attendance || !$attendance->check_in) {
                return response()->json([
                    'error' => 'No active check-in found',
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

            if (!$request->boolean('is_auto_trap') && $distance > $checkInGeofence->radius) {
                Log::warning("Employee {$employee->id} is OUTSIDE check-in geofence for checkout");
                return response()->json([
                    'error' => 'You must be within the same location where you checked in to check out. Current location is too far from your check-in location.',
                ], 403);
            }

            Log::info("Employee {$employee->id} is INSIDE check-in geofence for checkout");

            // Save photo if exists
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('attendance-photos', 'public');
            }

            // Parse app usages if provided
            $appUsages = null;
            if ($request->filled('app_usages')) {
                $raw = $request->input('app_usages');
                if (is_string($raw)) {
                    $decoded = json_decode($raw, true);
                    $appUsages = is_array($decoded) ? $decoded : null;
                } elseif (is_array($raw)) {
                    $appUsages = $raw;
                }
            }

            $updateData = [
                'check_out' => $time,
                'check_out_lat' => $lat,
                'check_out_lng' => $lng,
                'check_out_photo' => $photoPath,
                'admin_id' => $employee->admin_id,
            ];

            if ($appUsages !== null) {
                $updateData['app_usages'] = $appUsages;
            }

            $attendance->update($updateData);

            Log::info("CheckOut successful for employee {$employee->id}");

            // Fetch all assigned geofences for employee
            $assignedGeofences = $employee->employeeGeofences()->where('is_active', true)->pluck('name');

            return response()->json([
                'message' => 'Check-out successful!',
                'attendance' => $attendance,
                'employee_name' => $employee->name,
                'admin_name' => $employee->admin ? ($employee->admin->business_name ?? $employee->admin->name) : null,
                'geofence_name' => $checkInGeofence->name,
                'assigned_geofences' => $assignedGeofences,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors(),
            ], 422);
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

            // Fetch normal geofence attendances
            $normalAttendances = Attendance::with('geofence')
                ->where('employee_id', $employee->id)
                ->get();

            // Fetch outside attendances
            $outsideAttendances = \App\Models\OutsideAttendance::where('employee_id', $employee->id)
                ->get();

            // Merge collections
            $allAttendances = $normalAttendances->concat($outsideAttendances);

            // Sort chronologically before grouping
            $formattedAttendances = $allAttendances->map(function ($attendance) {
                // Ensure date is a simple 'Y-m-d' string
                $attendance->date_formatted = is_string($attendance->date) ? substr($attendance->date, 0, 10) : $attendance->date->format('Y-m-d');
                
                // Add type identification and locations
                if (get_class($attendance) === 'App\\Models\\OutsideAttendance') {
                    $attendance->type = 'outside';
                    $attendance->checkin_loc = $attendance->checkin_location;
                    $attendance->checkout_loc = $attendance->checkout_location;
                    $attendance->reason = $attendance->reason;
                } else {
                    $attendance->type = 'normal';
                    $attendance->checkin_loc = $attendance->geofence->name ?? 'OFFICE HUB';
                    $attendance->checkout_loc = $attendance->geofence->name ?? 'OFFICE HUB';
                    $attendance->reason = null;
                }
                
                return $attendance;
            });

            // Group by date so each day appears as a single unified card in the mobile app
            $attendances = $formattedAttendances->groupBy('date_formatted')->map(function ($dayRecords, $dateKey) {
                $sorted = $dayRecords->sortBy(function ($att) {
                    return is_string($att->check_in) ? $att->check_in : ($att->check_in ? $att->check_in->toDateTimeString() : '00:00:00');
                })->values();

                $firstSession = $sorted->first();
                $lastSession = $sorted->last();

                // Check if any session today is still active/unclosed
                $hasActiveSession = $sorted->contains(function ($att) {
                    return empty($att->check_out);
                });

                // Earliest check-in of the day
                $earliestCheckIn = $firstSession->check_in;

                // Latest check-out of the day (null if still on-duty)
                $latestCheckOut = $hasActiveSession ? null : $lastSession->check_out;

                // Calculate cumulative worked seconds and format each individual session
                $totalWorkedSeconds = 0;
                $formattedSessions = [];

                foreach ($sorted as $session) {
                    $sessionSeconds = 0;
                    $sessionDuration = '--:--';
                    
                    if (!empty($session->check_in) && !empty($session->check_out)) {
                        $cIn = \Carbon\Carbon::parse($session->check_in);
                        $cOut = \Carbon\Carbon::parse($session->check_out);
                        $sessionSeconds = abs($cIn->diffInSeconds($cOut));
                        $totalWorkedSeconds += $sessionSeconds;
                        $sH = (int) floor($sessionSeconds / 3600);
                        $sM = (int) round(($sessionSeconds % 3600) / 60);
                        if ($sM == 60) {
                            $sH += 1;
                            $sM = 0;
                        }
                        $sessionDuration = ($sH > 0) ? "{$sH}h {$sM}m" : "{$sM}m";
                    }

                    $formattedSessions[] = [
                        'id' => $session->id,
                        'check_in' => $session->check_in ? (is_string($session->check_in) ? $session->check_in : $session->check_in->toDateTimeString()) : null,
                        'check_out' => $session->check_out ? (is_string($session->check_out) ? $session->check_out : $session->check_out->toDateTimeString()) : null,
                        'check_in_time' => $session->check_in ? \Carbon\Carbon::parse($session->check_in)->format('h:i A') : '--:--',
                        'check_out_time' => $session->check_out ? \Carbon\Carbon::parse($session->check_out)->format('h:i A') : '--:--',
                        'total_time' => $sessionDuration,
                        'duration' => $sessionDuration,
                        'seconds' => $sessionSeconds,
                        'type' => $session->type ?? 'normal',
                        'checkin_loc' => $session->checkin_loc ?? $session->geofence->name ?? 'OFFICE HUB',
                        'checkout_loc' => $session->checkout_loc ?? $session->geofence->name ?? 'OFFICE HUB',
                        'reason' => $session->reason ?? null,
                        'app_usages' => $session->app_usages ?? [],
                    ];
                }

                $totalWorkedMinutes = (int) round($totalWorkedSeconds / 60);
                $h = (int) floor($totalWorkedSeconds / 3600);
                $m = (int) round(($totalWorkedSeconds % 3600) / 60);
                if ($m == 60) {
                    $h += 1;
                    $m = 0;
                }
                $s = (int) ($totalWorkedSeconds % 60);
                
                $totalTimeFormatted = "{$h}h {$m}m";
                $totalHoursFormatted = sprintf('%02d:%02d:%02d', $h, floor(($totalWorkedSeconds % 3600) / 60), $s);

                $merged = clone $lastSession;
                $merged->check_in = $earliestCheckIn;
                $merged->check_out = $latestCheckOut;
                $merged->total_minutes = $totalWorkedMinutes;
                $merged->total_seconds = $totalWorkedSeconds;
                $merged->total_hours = round($totalWorkedSeconds / 3600, 2);
                $merged->total_time = $totalTimeFormatted;
                $merged->total_time_formatted = $totalHoursFormatted;
                $merged->check_in_lat = $firstSession->check_in_lat;
                $merged->check_in_lng = $firstSession->check_in_lng;
                $merged->check_in_photo = $firstSession->check_in_photo;
                $merged->checkin_loc = $firstSession->checkin_loc;
                $merged->checkout_loc = $lastSession->checkout_loc;
                $merged->punches_count = count($formattedSessions);
                $merged->sessions = $formattedSessions;
                $merged->app_usages = $lastSession->app_usages ?? [];

                return $merged;
            })->sortByDesc(function ($attendance) {
                $checkInTime = is_string($attendance->check_in) ? $attendance->check_in : ($attendance->check_in ? $attendance->check_in->toDateTimeString() : '00:00:00');
                return $attendance->date_formatted . ' ' . $checkInTime;
            })->values();

            $assignedGeofences = $employee->employeeGeofences()->where('is_active', true)->pluck('name');

            return response()->json([
                'employee_name' => $employee->name,
                'admin_name' => $employee->admin ? ($employee->admin->business_name ?? $employee->admin->name) : null,
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
     * Get active unclosed normal attendance record within the last 24 hours.
     */
    private function getActiveAttendance($employeeId)
    {
        return Attendance::where('employee_id', $employeeId)
            ->whereNotNull('check_in')
            ->whereNull('check_out')
            ->where('check_in', '>=', now()->subHours(24))
            ->latest('check_in')
            ->first();
    }

    /**
     * Get active unclosed outside attendance record within the last 24 hours.
     */
    private function getActiveOutsideAttendance($employeeId)
    {
        return \App\Models\OutsideAttendance::where('employee_id', $employeeId)
            ->whereNotNull('check_in')
            ->whereNull('check_out')
            ->where('check_in', '>=', now()->subHours(24))
            ->latest('check_in')
            ->first();
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

    public function getEmployeeData(Request $request)
    {
        $user = auth()->user();
        $today = now()->format('Y-m-d');
        
        // Find active open session within last 24 hours (handles cross-midnight checkouts)
        $activeAttendance = $this->getActiveAttendance($user->id);
        $activeOutside = $this->getActiveOutsideAttendance($user->id);

        $geofences = $user->employeeGeofences()->select('name', 'latitude', 'longitude', 'radius', 'tracking_radius', 'lunch_start_time', 'lunch_end_time')->get();

        $admin = $user->admin;
        $isExpired = $admin->subscription_expires_at && now()->greaterThan($admin->subscription_expires_at);
        $adminSubStatus = ($admin->subscription_status !== 'active' || $isExpired) ? 'inactive' : 'active';

        $isCheckedIn = ($activeAttendance && $activeAttendance->check_in) || ($activeOutside && $activeOutside->check_in);
        $isOutside = (bool) ($activeOutside && $activeOutside->check_in);
        $checkedInGeofenceName = ($activeAttendance && $activeAttendance->check_in) ? ($activeAttendance->geofence->name ?? null) : null;

        return response()->json([
            'employee_name' => $user->name,
            'admin_name' => $admin->business_name ?? $admin->name ?? 'Admin',
            'phone_restriction' => $user->phone_used_restricted ?? false,
            'admin_subscription_status' => $adminSubStatus,
            'assigned_geofences' => $geofences,
            'attendance_status' => [
                'is_checked_in' => (bool) $isCheckedIn,
                'is_completed' => false,
                'is_outside' => (bool) $isOutside,
                'checked_in_geofence_name' => $checkedInGeofenceName,
            ]
        ]);
    }

    public function outsideCheckIn(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'photo' => 'required|image|max:5120',
                'checkin_location' => 'nullable|string',
            ]);

            $employee = $request->user();
            $admin = $employee->admin;
            $isExpired = $admin->subscription_expires_at && now()->greaterThan($admin->subscription_expires_at);

            if ($admin->subscription_status !== 'active' || $isExpired) {
                return response()->json([
                    'error' => 'Your organization\'s subscription has expired. Attendance is disabled.',
                ], 403);
            }

            $time = $request->filled('timestamp') ? \Carbon\Carbon::parse($request->timestamp) : now();
            $today = $time->format('Y-m-d');

            // Check if already checked in (active session within last 24h in normal or outside)
            $activeAttendance = $this->getActiveAttendance($employee->id);
            $activeOutside = $this->getActiveOutsideAttendance($employee->id);

            if ($activeAttendance || $activeOutside) {
                return response()->json([
                    'error' => 'You are already checked in. Please check out first.',
                ], 400);
            }

            // Save photo
            $photoPath = $request->file('photo')->store('attendance-photos', 'public');

            // Create outside attendance record
            $attendance = \App\Models\OutsideAttendance::create([
                'admin_id' => $employee->admin_id,
                'employee_id' => $employee->id,
                'date' => $today,
                'check_in' => $time,
                'check_in_lat' => $request->latitude,
                'check_in_lng' => $request->longitude,
                'check_in_photo' => $photoPath,
                'checkin_location' => $request->checkin_location ?? "{$request->latitude}, {$request->longitude}",
                'reason' => $request->reason,
                'status' => 'present',
            ]);

            Log::info("Outside CheckIn successful for employee {$employee->id}");

            return response()->json([
                'message' => 'Outside check-in successful!',
                'attendance' => $attendance,
                'employee_name' => $employee->name,
                'admin_name' => $employee->admin ? ($employee->admin->business_name ?? $employee->admin->name) : null,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Outside check-in error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function outsideCheckOut(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'photo' => $request->boolean('is_auto_trap') ? 'nullable|image|max:5120' : 'required|image|max:5120',
                'checkout_location' => 'nullable|string',
                'reason' => 'nullable|string',
            ]);

            $employee = $request->user();
            $time = $request->filled('timestamp') ? \Carbon\Carbon::parse($request->timestamp) : now();

            $attendance = $this->getActiveOutsideAttendance($employee->id);

            if (!$attendance || !$attendance->check_in) {
                return response()->json([
                    'error' => 'No active outside check-in found',
                ], 400);
            }

            // Save photo if exists
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('attendance-photos', 'public');
            }

            // Parse app usages if provided
            $appUsages = null;
            if ($request->filled('app_usages')) {
                $raw = $request->input('app_usages');
                if (is_string($raw)) {
                    $decoded = json_decode($raw, true);
                    $appUsages = is_array($decoded) ? $decoded : null;
                } elseif (is_array($raw)) {
                    $appUsages = $raw;
                }
            }

            $updateData = [
                'check_out' => $time,
                'check_out_lat' => $request->latitude,
                'check_out_lng' => $request->longitude,
                'check_out_photo' => $photoPath,
                'checkout_location' => $request->checkout_location ?? "{$request->latitude}, {$request->longitude}",
                'reason' => $request->reason ?: $attendance->reason,
            ];

            if ($appUsages !== null) {
                $updateData['app_usages'] = $appUsages;
            }

            $attendance->update($updateData);

            Log::info("Outside CheckOut successful for employee {$employee->id}");

            return response()->json([
                'message' => 'Outside check-out successful!',
                'attendance' => $attendance,
                'employee_name' => $employee->name,
                'admin_name' => $employee->admin ? ($employee->admin->business_name ?? $employee->admin->name) : null,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Outside check-out error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateLocation(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $employee = $request->user();
            $lat = (float) $request->latitude;
            $lng = (float) $request->longitude;

            // ALWAYS track the employee's location to allow live tracking from the admin panel.
            \App\Models\EmployeeLocation::updateOrCreate(
                ['employee_id' => $employee->id],
                [
                    'latitude' => $lat, 
                    'longitude' => $lng, 
                    'updated_at' => now()
                ]
            );

            return response()->json([
                'status' => 'tracking',
                'message' => 'Location captured'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
