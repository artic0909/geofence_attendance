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

        // Base query for Normal Attendance
        $normalQuery = \App\Models\Attendance::with(['employee', 'geofence'])
            ->where('admin_id', $adminId);

        // Base query for Outside Attendance
        $outsideQuery = \App\Models\OutsideAttendance::with(['employee'])
            ->where('admin_id', $adminId);

        // Apply filters
        if ($request->filled('geofence')) {
            $normalQuery->where('geofence_id', $request->geofence);
            $outsideQuery->whereRaw('1 = 0'); 
        }

        if ($request->filled('date')) {
            $normalQuery->whereDate('date', $request->date);
            $outsideQuery->whereDate('date', $request->date);
        }

        if ($request->filled('employee_name')) {
            $normalQuery->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)->where('name', 'like', '%' . $request->employee_name . '%');
            });
            $outsideQuery->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        // Fetch and Merge
        $normalRecords = $normalQuery->get()->map(function($a) { $a->attendance_type = 'normal'; return $a; });
        $outsideRecords = $outsideQuery->get()->map(function($a) { $a->attendance_type = 'outside'; return $a; });

        $merged = $normalRecords->concat($outsideRecords)->sortByDesc('created_at')->values();

        // Manual Pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $recent_attendances = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.dashboard', compact('stats', 'recent_attendances', 'geofences'));
    }
}
