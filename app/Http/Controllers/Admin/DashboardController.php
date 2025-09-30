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

        $geofences = Geofence::all();

        $stats = [
            'total_employees' => Employee::count(),
            'total_geofences' => Geofence::count(),
            'today_attendances' => Attendance::whereDate('date', today())->count(),
            'active_employees' => Employee::where('is_active', true)->count(),
        ];

        // Base query for recent attendances
        $query = Attendance::with(['employee', 'geofence']);

        // Filter by geofence
        if ($request->filled('geofence')) {
            $query->where('geofence_id', $request->geofence);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Filter by employee name (optional)
        if ($request->filled('employee_name')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        // Get attendances
        $recent_attendances = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.dashboard', compact('stats', 'recent_attendances', 'geofences'));
    }
}
