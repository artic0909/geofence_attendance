<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Geofence;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $adminId = auth()->guard('admin')->id();

        // Get admin's geofences
        $geofences = \App\Models\Geofence::where('admin_id', $adminId)->get();

        // Stats
        $stats = [
            'total_employees' => \App\Models\Employee::where('admin_id', $adminId)->count(),
            'total_geofences' => \App\Models\Geofence::where('admin_id', $adminId)->count(),
            'today_attendances' => \App\Models\Attendance::where('admin_id', $adminId)
                ->whereDate('date', today())
                ->count() + \App\Models\OutsideAttendance::where('admin_id', $adminId)
                ->whereDate('date', today())
                ->count(),
            'active_employees' => \App\Models\Employee::where('admin_id', $adminId)
                ->where('is_active', true)
                ->count(),
        ];

        // Get IDs of employees who have already given attendance today (Normal or Outside)
        $attendedEmployeeIds = \App\Models\Attendance::where('admin_id', $adminId)
            ->whereDate('date', today())
            ->pluck('employee_id')
            ->concat(
                \App\Models\OutsideAttendance::where('admin_id', $adminId)
                    ->whereDate('date', today())
                    ->pluck('employee_id')
            )
            ->unique();

        // Get employees who have NOT given attendance today
        $pendingQuery = \App\Models\Employee::where('admin_id', $adminId)
            ->where('is_active', true)
            ->whereNotIn('id', $attendedEmployeeIds);

        // Apply filters if any
        if ($request->filled('employee_name')) {
            $pendingQuery->where('name', 'like', '%' . $request->employee_name . '%');
        }

        $pending_employees = $pendingQuery->orderBy('name', 'asc')->paginate(10);

        return view('admin.dashboard', compact('stats', 'pending_employees', 'geofences'));
    }
}
