<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Geofence;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $adminId = auth()->guard('admin')->id();

        // Get admin's geofences
        $geofences = Geofence::where('admin_id', $adminId)->get();

        // Stats
        $stats = [
            'total_employees' => Employee::where('admin_id', $adminId)->count(),
            'total_geofences' => Geofence::where('admin_id', $adminId)->count(),
            'today_attendances' => Attendance::where('admin_id', $adminId)
                ->whereDate('date', today())
                ->count(),
            'active_employees' => Employee::where('admin_id', $adminId)
                ->where('is_active', true)
                ->count(),
        ];

        // Base query
        $query = Attendance::with(['employee', 'geofence'])
            ->where('admin_id', $adminId);

        // Filter by geofence
        if ($request->filled('geofence')) {
            $query->where('geofence_id', $request->geofence);
        }

        // Filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        // Filter by employee name (optional)
        if ($request->filled('employee_name')) {
            $query->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)
                    ->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        // Fetch paginated results
        $recent_attendances = $query->orderBy('date', 'desc')->paginate(10);

        return view('admin.attendance.index', compact('stats', 'recent_attendances', 'geofences'));
    }
}
