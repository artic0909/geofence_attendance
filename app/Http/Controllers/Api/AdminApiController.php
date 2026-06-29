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

        $presentEmployees = User::whereIn('id', $allPresentIds)->get()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? 'N/A',
                'designation' => clone $user->designation ? clone $user->designation->name : 'Employee'
            ];
        });

        // The above mapping had an issue with "clone" being mistakenly inserted by me earlier in my mind. 
        // I will write this cleanly below:
        $presentEmployeesClean = User::with('designation')->whereIn('id', $allPresentIds)->get()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? 'N/A',
                'designation' => $user->designation ? $user->designation->name : 'Employee'
            ];
        });

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

        $absentEmployees = User::with('designation')->where('admin_id', $adminId)
            ->where('role', 'employee')
            ->whereNotIn('id', $allPresentIds)
            ->get()->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? 'N/A',
                    'designation' => $user->designation ? $user->designation->name : 'Employee'
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

        return response()->json([
            'employee_name' => $employee->name,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'last_updated' => $location->updated_at->diffForHumans()
        ]);
    }
}
