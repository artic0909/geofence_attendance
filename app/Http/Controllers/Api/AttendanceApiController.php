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
                $mergedUsages = $this->mergeAppUsages($attendance->app_usages, $appUsages);
                $updateData['app_usages'] = $mergedUsages;
            }

            $attendance->update($updateData);

            Log::info("CheckOut successful for employee {$employee->id}");

            // Fetch all assigned geofences for employee
            $assignedGeofences = $employee->employeeGeofences()->pluck('name');

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

    /**
     * Mid-day / Lunch start App Usage synchronization
     */
    public function syncAppUsage(Request $request)
    {
        try {
            $employee = $request->user();
            $activeAttendance = $this->getActiveAttendance($employee->id);
            $activeOutside = $this->getActiveOutsideAttendance($employee->id);

            $appUsages = null;
            if ($request->has('app_usages')) {
                $raw = $request->input('app_usages');
                if (is_string($raw)) {
                    $decoded = json_decode($raw, true);
                    $appUsages = is_array($decoded) ? $decoded : null;
                } elseif (is_array($raw)) {
                    $appUsages = $raw;
                }
            }

            Log::info("syncAppUsage invoked by employee {$employee->id}. Usages: " . json_encode($appUsages));

            if ($appUsages !== null) {
                if ($activeAttendance) {
                    $activeAttendance->update(['app_usages' => $appUsages]);
                    Log::info("Synced app_usages to active normal attendance #{$activeAttendance->id}");
                } elseif ($activeOutside) {
                    $activeOutside->update(['app_usages' => $appUsages]);
                    Log::info("Synced app_usages to active outside attendance #{$activeOutside->id}");
                } else {
                    // Fallback to today's latest attendance for this employee
                    $todayAttendance = Attendance::where('employee_id', $employee->id)
                        ->where('date', now()->format('Y-m-d'))
                        ->latest('check_in')
                        ->first();
                    if ($todayAttendance) {
                        $todayAttendance->update(['app_usages' => $appUsages]);
                        Log::info("Synced app_usages to today attendance #{$todayAttendance->id}");
                    }
                }
            }

            return response()->json([
                'message' => 'App usage synced successfully',
                'app_usages' => $appUsages,
            ]);
        } catch (\Exception $e) {
            Log::error('Sync app usage error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
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
                $merged->app_usages = $this->aggregateAppUsagesAcrossSessions($sorted) ?? ($lastSession->app_usages ?? []);

                return $merged;
            })->sortByDesc(function ($attendance) {
                $checkInTime = is_string($attendance->check_in) ? $attendance->check_in : ($attendance->check_in ? $attendance->check_in->toDateTimeString() : '00:00:00');
                return $attendance->date_formatted . ' ' . $checkInTime;
            })->values();

            $assignedGeofences = $employee->employeeGeofences()->pluck('name');

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

        $geofences = $user->employeeGeofences()->get();

        $admin = $user->admin;
        $isExpired = $admin->subscription_expires_at && now()->greaterThan($admin->subscription_expires_at);
        $adminSubStatus = ($admin->subscription_status !== 'active' || $isExpired) ? 'inactive' : 'active';

        $isCheckedIn = ($activeAttendance && $activeAttendance->check_in) || ($activeOutside && $activeOutside->check_in);
        $isOutside = (bool) ($activeOutside && $activeOutside->check_in);
        $checkedInGeofenceName = ($activeAttendance && $activeAttendance->check_in) ? ($activeAttendance->geofence->name ?? null) : null;

        $activeCheckInTime = ($activeAttendance && $activeAttendance->check_in) 
            ? $activeAttendance->check_in->toIso8601String() 
            : (($activeOutside && $activeOutside->check_in) ? $activeOutside->check_in->toIso8601String() : null);

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
                'check_in_time' => $activeCheckInTime,
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
                $mergedUsages = $this->mergeAppUsages($attendance->app_usages, $appUsages);
                $updateData['app_usages'] = $mergedUsages;
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

    /**
     * Merge existing (e.g. before-lunch) app usages with checkout app usages
     * so before-lunch tracking is never erased when employee checks out.
     */
    private function mergeAppUsages($existing, $incoming)
    {
        if (empty($existing)) return $incoming;
        if (empty($incoming)) return $existing;

        $existingBefore = $existing['before_lunch'] ?? [];
        $incomingBefore = $incoming['before_lunch'] ?? [];
        $incomingAfter = $incoming['after_lunch'] ?? [];

        // If incoming before_lunch is empty, retain existing before_lunch from mid-day lunch sync
        $finalBefore = (!empty($incomingBefore)) ? $incomingBefore : $existingBefore;
        $finalAfter = $incomingAfter;

        // Rebuild consolidated summary
        $summaryMap = [];
        foreach ($finalBefore as $app) {
            $pkg = $app['package_name'] ?? ($app['app_name'] ?? 'unknown');
            $bSec = (int) ($app['usage_seconds'] ?? ($app['before_lunch_seconds'] ?? 0));
            $summaryMap[$pkg] = [
                'package_name' => $pkg,
                'app_name' => $app['app_name'] ?? $pkg,
                'before_lunch_seconds' => $bSec,
                'before_lunch_formatted' => $app['usage_formatted'] ?? ($app['before_lunch_formatted'] ?? $this->formatSeconds($bSec)),
                'after_lunch_seconds' => 0,
                'after_lunch_formatted' => '0s',
                'total_seconds' => $bSec,
                'total_formatted' => $app['usage_formatted'] ?? ($app['before_lunch_formatted'] ?? $this->formatSeconds($bSec)),
            ];
        }

        foreach ($finalAfter as $app) {
            $pkg = $app['package_name'] ?? ($app['app_name'] ?? 'unknown');
            $aSec = (int) ($app['usage_seconds'] ?? ($app['after_lunch_seconds'] ?? 0));
            if (isset($summaryMap[$pkg])) {
                $bSec = $summaryMap[$pkg]['before_lunch_seconds'];
                $tot = $bSec + $aSec;
                $summaryMap[$pkg]['after_lunch_seconds'] = $aSec;
                $summaryMap[$pkg]['after_lunch_formatted'] = $app['usage_formatted'] ?? ($app['after_lunch_formatted'] ?? $this->formatSeconds($aSec));
                $summaryMap[$pkg]['total_seconds'] = $tot;
                $summaryMap[$pkg]['total_formatted'] = $this->formatSeconds($tot);
            } else {
                $summaryMap[$pkg] = [
                    'package_name' => $pkg,
                    'app_name' => $app['app_name'] ?? $pkg,
                    'before_lunch_seconds' => 0,
                    'before_lunch_formatted' => '0s',
                    'after_lunch_seconds' => $aSec,
                    'after_lunch_formatted' => $app['usage_formatted'] ?? ($app['after_lunch_formatted'] ?? $this->formatSeconds($aSec)),
                    'total_seconds' => $aSec,
                    'total_formatted' => $app['usage_formatted'] ?? ($app['after_lunch_formatted'] ?? $this->formatSeconds($aSec)),
                ];
            }
        }

        $summaryList = array_values($summaryMap);
        usort($summaryList, function($a, $b) {
            return ($b['total_seconds'] ?? 0) <=> ($a['total_seconds'] ?? 0);
        });

        $totalTracked = array_sum(array_column($summaryList, 'total_seconds'));

        return [
            'before_lunch' => $finalBefore,
            'after_lunch' => $finalAfter,
            'summary' => $summaryList,
            'total_tracked_seconds' => $totalTracked,
            'total_tracked_formatted' => $this->formatSeconds($totalTracked),
            'lunch_start_time' => $incoming['lunch_start_time'] ?? ($existing['lunch_start_time'] ?? null),
            'lunch_end_time' => $incoming['lunch_end_time'] ?? ($existing['lunch_end_time'] ?? null),
        ];
    }

    /**
     * Aggregate and sum app usages across multiple daily attendance punches/sessions.
     */
    private function aggregateAppUsagesAcrossSessions($sessions)
    {
        $summaryMap = [];
        $lunchStart = null;
        $lunchEnd = null;
        $hasAnyUsage = false;

        foreach ($sessions as $session) {
            $usages = $session->app_usages;
            if (empty($usages)) continue;

            if (is_string($usages)) {
                $decoded = json_decode($usages, true);
                $usages = is_array($decoded) ? $decoded : null;
            }
            if (empty($usages)) continue;

            $hasAnyUsage = true;

            if (empty($lunchStart) && !empty($usages['lunch_start_time'])) {
                $lunchStart = $usages['lunch_start_time'];
            }
            if (empty($lunchEnd) && !empty($usages['lunch_end_time'])) {
                $lunchEnd = $usages['lunch_end_time'];
            }

            $beforeList = $usages['before_lunch'] ?? [];
            $afterList = $usages['after_lunch'] ?? [];

            // Support legacy flat list if before/after not split
            if (empty($beforeList) && empty($afterList) && is_array($usages) && !isset($usages['summary'])) {
                $beforeList = $usages;
            }

            foreach ($beforeList as $app) {
                $pkg = $app['package_name'] ?? ($app['app_name'] ?? 'unknown');
                $name = $app['app_name'] ?? $pkg;
                $sec = (int) ($app['usage_seconds'] ?? ($app['before_lunch_seconds'] ?? 0));
                if ($sec <= 0) continue;

                if (!isset($summaryMap[$pkg])) {
                    $summaryMap[$pkg] = [
                        'package_name' => $pkg,
                        'app_name' => $name,
                        'before_lunch_seconds' => 0,
                        'after_lunch_seconds' => 0,
                        'total_seconds' => 0,
                    ];
                }
                $summaryMap[$pkg]['before_lunch_seconds'] += $sec;
                $summaryMap[$pkg]['total_seconds'] += $sec;
            }

            foreach ($afterList as $app) {
                $pkg = $app['package_name'] ?? ($app['app_name'] ?? 'unknown');
                $name = $app['app_name'] ?? $pkg;
                $sec = (int) ($app['usage_seconds'] ?? ($app['after_lunch_seconds'] ?? 0));
                if ($sec <= 0) continue;

                if (!isset($summaryMap[$pkg])) {
                    $summaryMap[$pkg] = [
                        'package_name' => $pkg,
                        'app_name' => $name,
                        'before_lunch_seconds' => 0,
                        'after_lunch_seconds' => 0,
                        'total_seconds' => 0,
                    ];
                }
                $summaryMap[$pkg]['after_lunch_seconds'] += $sec;
                $summaryMap[$pkg]['total_seconds'] += $sec;
            }
        }

        if (!$hasAnyUsage && empty($summaryMap)) {
            return null;
        }

        $finalBeforeList = [];
        $finalAfterList = [];
        $finalSummaryList = [];

        foreach ($summaryMap as $pkg => $data) {
            $bSec = $data['before_lunch_seconds'];
            $aSec = $data['after_lunch_seconds'];
            $tot = $data['total_seconds'];
            $name = $data['app_name'];

            if ($bSec > 0) {
                $finalBeforeList[] = [
                    'package_name' => $pkg,
                    'app_name' => $name,
                    'usage_seconds' => $bSec,
                    'usage_formatted' => $this->formatSeconds($bSec),
                ];
            }

            if ($aSec > 0) {
                $finalAfterList[] = [
                    'package_name' => $pkg,
                    'app_name' => $name,
                    'usage_seconds' => $aSec,
                    'usage_formatted' => $this->formatSeconds($aSec),
                ];
            }

            $finalSummaryList[] = [
                'package_name' => $pkg,
                'app_name' => $name,
                'before_lunch_seconds' => $bSec,
                'before_lunch_formatted' => $this->formatSeconds($bSec),
                'after_lunch_seconds' => $aSec,
                'after_lunch_formatted' => $this->formatSeconds($aSec),
                'total_seconds' => $tot,
                'total_formatted' => $this->formatSeconds($tot),
            ];
        }

        usort($finalBeforeList, fn($a, $b) => $b['usage_seconds'] <=> $a['usage_seconds']);
        usort($finalAfterList, fn($a, $b) => $b['usage_seconds'] <=> $a['usage_seconds']);
        usort($finalSummaryList, fn($a, $b) => $b['total_seconds'] <=> $a['total_seconds']);

        $totalTrackedSeconds = array_sum(array_column($finalSummaryList, 'total_seconds'));

        return [
            'before_lunch' => $finalBeforeList,
            'after_lunch' => $finalAfterList,
            'summary' => $finalSummaryList,
            'total_tracked_seconds' => $totalTrackedSeconds,
            'total_tracked_formatted' => $this->formatSeconds($totalTrackedSeconds),
            'lunch_start_time' => $lunchStart,
            'lunch_end_time' => $lunchEnd,
        ];
    }

    private function formatSeconds($sec)
    {
        $sec = (int) $sec;
        if ($sec < 60) return $sec . 's';
        $m = floor($sec / 60);
        $s = $sec % 60;
        return $s > 0 ? "{$m}m {$s}s" : "{$m}m";
    }
}
