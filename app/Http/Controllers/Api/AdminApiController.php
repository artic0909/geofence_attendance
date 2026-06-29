<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Geofence;
use App\Models\Attendance;
use App\Models\OutsideAttendance;
use App\Models\EmployeeLocation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminApiController extends Controller
{
    public function dashboard(Request $request)
    {
        $adminId = $request->user()->id;

        $totalEmployees = User::where('admin_id', $adminId)->where('role', 'employee')->count();
        $totalGeofences = Geofence::where('admin_id', $adminId)->count();

        $employeeIds = User::where('admin_id', $adminId)->where('role', 'employee')->pluck('id');

        $today = Carbon::today();

        // Get employees who checked in onsite today
        $onsitePresent = Attendance::whereIn('employee_id', $employeeIds)
            ->whereDate('created_at', $today)
            ->pluck('employee_id')
            ->toArray();

        // Get employees who checked in outside today
        $outsidePresent = OutsideAttendance::whereIn('employee_id', $employeeIds)
            ->whereDate('created_at', $today)
            ->pluck('employee_id')
            ->toArray();

        $allPresentIds = array_unique(array_merge($onsitePresent, $outsidePresent));
        $todayPresentCount = count($allPresentIds);
        $todayAbsentCount = max(0, $totalEmployees - $todayPresentCount);

        return response()->json([
            'total_geofences' => $totalGeofences,
            'total_employees' => $totalEmployees,
            'today_present' => $todayPresentCount,
            'today_absent' => $todayAbsentCount,
        ]);
    }

    public function todayPresent(Request $request)
    {
        $adminId = $request->user()->id;
        $employeeIds = User::where('admin_id', $adminId)->where('role', 'employee')->pluck('id');
        $today = Carbon::today();

        $onsitePresent = Attendance::whereIn('employee_id', $employeeIds)
            ->whereDate('created_at', $today)
            ->pluck('employee_id')
            ->toArray();

        $outsidePresent = OutsideAttendance::whereIn('employee_id', $employeeIds)
            ->whereDate('created_at', $today)
            ->pluck('employee_id')
            ->toArray();

        $allPresentIds = array_unique(array_merge($onsitePresent, $outsidePresent));

        $presentEmployeesClean = [];

        foreach ($allPresentIds as $empId) {
            $employee = User::with('designation')->find($empId);
            
            $attendance = Attendance::with('geofence')->where('employee_id', $empId)
                ->whereDate('created_at', $today)->latest()->first();
                
            if (!$attendance) {
                $attendance = OutsideAttendance::where('employee_id', $empId)
                    ->whereDate('created_at', $today)->latest()->first();
                if ($attendance) {
                    $attendance->attendance_type = 'outside';
                }
            }

            if ($attendance && $employee) {
                $checkIn = $attendance->check_in ? Carbon::parse($attendance->check_in)->format('h:i A') : '--:--';
                $checkOut = $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : null;
                
                $hours = '--:--:--';
                if ($attendance->check_in && $attendance->check_out) {
                    $hours = Carbon::parse($attendance->check_in)->diff(Carbon::parse($attendance->check_out))->format('%H:%I:%S');
                }
                
                $location = ($attendance->attendance_type == 'outside')
                    ? ($attendance->checkin_location ?? 'Outside')
                    : ($attendance->geofence->name ?? 'N/A');

                $presentEmployeesClean[] = [
                    'id' => $employee->id,
                    'employee_id' => $employee->employee_id ?? 'N/A',
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'phone' => $employee->phone ?? 'N/A',
                    'designation' => $employee->designation ? $employee->designation->name : 'Employee',
                    
                    'type' => ucfirst($attendance->attendance_type ?? 'Normal'),
                    'is_privacy_violation' => $attendance->is_auto_checkout_trap ?? false,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'hours' => $hours,
                    'location' => $location,
                ];
            }
        }

        return response()->json([
            'present_employees' => $presentEmployeesClean
        ]);
    }

    public function todayAbsent(Request $request)
    {
        $adminId = $request->user()->id;
        $employeeIds = User::where('admin_id', $adminId)->where('role', 'employee')->pluck('id');
        $today = Carbon::today();

        $onsitePresent = Attendance::whereIn('employee_id', $employeeIds)
            ->whereDate('created_at', $today)
            ->pluck('employee_id')
            ->toArray();

        $outsidePresent = OutsideAttendance::whereIn('employee_id', $employeeIds)
            ->whereDate('created_at', $today)
            ->pluck('employee_id')
            ->toArray();

        $allPresentIds = array_unique(array_merge($onsitePresent, $outsidePresent));

        $absentEmployees = User::with(['designation', 'geofences'])->where('admin_id', $adminId)
            ->where('role', 'employee')
            ->whereNotIn('id', $allPresentIds)
            ->get()->map(function($user) {
                return [
                    'id' => $user->id,
                    'employee_id' => $user->employee_id ?? 'N/A',
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? 'N/A',
                    'designation' => $user->designation ? $user->designation->name : 'Employee',
                    'geofences' => $user->geofences->pluck('name')->toArray()
                ];
            });

        return response()->json([
            'absent_employees' => $absentEmployees
        ]);
    }

    public function trackEmployee(Request $request, $employeeId)
    {
        $adminId = $request->user()->id;

        // Verify this employee belongs to the admin
        $employee = User::where('id', $employeeId)
            ->where('admin_id', $adminId)
            ->where('role', 'employee')
            ->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $location = EmployeeLocation::where('employee_id', $employeeId)->first();

        if (!$location) {
            return response()->json(['message' => 'No location data available'], 404);
        }

        $attendance = Attendance::with('geofence')->where('employee_id', $employee->id)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();

        $attendanceType = 'none';
        $geofenceData = null;

        if ($attendance) {
            $attendanceType = 'onsite';
            if ($attendance->geofence) {
                $geofenceData = [
                    'name' => $attendance->geofence->name,
                    'latitude' => $attendance->geofence->latitude,
                    'longitude' => $attendance->geofence->longitude,
                    'radius' => $attendance->geofence->radius,
                    'tracking_radius' => $attendance->geofence->tracking_radius,
                ];
            }
        } else {
            $attendance = OutsideAttendance::where('employee_id', $employee->id)
                ->whereDate('created_at', Carbon::today())
                ->latest()
                ->first();
            if ($attendance) {
                $attendanceType = 'outside';
            }
        }

        return response()->json([
            'employee_name' => $employee->name,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'last_updated' => $location->updated_at->diffForHumans(),
            'attendance_type' => $attendanceType,
            'geofence' => $geofenceData,
            'checkin_location' => $attendanceType === 'outside' ? $attendance->checkin_location : null,
        ]);
    }

    public function getSettings(Request $request)
    {
        $admin = $request->user();

        return response()->json([
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'phone' => $admin->phone,
            'business_name' => $admin->business_name,
            'gst_number' => $admin->gst_number,
            'address_line_1' => $admin->address_line_1,
            'address_line_2' => $admin->address_line_2,
            'city' => $admin->city,
            'state' => $admin->state,
            'zip_code' => $admin->zip_code,
        ]);
    }

    public function updateSettings(Request $request)
    {
        $admin = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$admin->id,
            'phone' => 'nullable|string|max:20',
            'business_name' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:255',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->business_name = $request->business_name;
        $admin->gst_number = $request->gst_number;
        $admin->address_line_1 = $request->address_line_1;
        $admin->address_line_2 = $request->address_line_2;
        $admin->city = $request->city;
        $admin->state = $request->state;
        $admin->zip_code = $request->zip_code;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return response()->json([
            'message' => 'Settings updated successfully',
            'admin' => $admin
        ]);
    }
}
