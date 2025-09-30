<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Geofence;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index() {
        $stats = [
            'total_employees' => Employee::count(),
            'total_geofences' => Geofence::count(),
            'today_attendances' => Attendance::whereDate('date', today())->count(),
            'active_employees' => Employee::where('is_active', true)->count(),
        ];

        $recent_attendances = Attendance::with(['employee', 'geofence'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_attendances'));
    }
}