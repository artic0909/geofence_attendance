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
