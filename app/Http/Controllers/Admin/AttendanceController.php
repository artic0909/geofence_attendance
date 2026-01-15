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
        $recent_attendances = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();

        return view('admin.attendance.index', compact('stats', 'recent_attendances', 'geofences'));
    }

    public function options(Request $request)
    {
        $adminId = auth()->guard('admin')->id(); // current logged-in admin id

        // Get only this admin’s geofences
        $geofences = Geofence::where('admin_id', $adminId)->get();

        // Stats for this admin only
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

        // Base query for recent attendances (for this admin only)
        $query = Attendance::with(['employee', 'geofence'])
            ->where('admin_id', $adminId);

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
            $query->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)
                    ->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        // Get attendances
        $recent_attendances = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.attendance.options', compact('stats', 'recent_attendances', 'geofences'));
    }

    public function todayAttedances(Request $request)
    {
        $adminId = auth()->guard('admin')->id();

        // Get only this admin's geofences
        $geofences = Geofence::where('admin_id', $adminId)->get();

        // Stats for this admin only
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

        // Base query for TODAY's attendances ONLY (for this admin only)
        $query = Attendance::with(['employee', 'geofence'])
            ->where('admin_id', $adminId)
            ->whereDate('date', today()); // Force today's date only

        // Filter by geofence
        if ($request->filled('geofence')) {
            $query->where('geofence_id', $request->geofence);
        }

        // Filter by employee name (optional)
        if ($request->filled('employee_name')) {
            $query->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)
                    ->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        // Get attendances - ordered by check_in time
        $recent_attendances = $query->orderBy('check_in', 'desc')->paginate(15)->withQueryString();

        return view('admin.attendance.today', compact('stats', 'recent_attendances', 'geofences'));
    }

    public function deleteAttendances(Request $request)
    {
        $adminId = auth()->guard('admin')->id();

        // Get geofences for filter
        $geofences = Geofence::where('admin_id', $adminId)->get();

        $attendances = collect();
        $fromDate = null;
        $toDate = null;
        $selectedGeofence = null;

        // If form is submitted with dates
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $selectedGeofence = $request->geofence;

            // Validate that from_date is not after to_date
            if (strtotime($fromDate) > strtotime($toDate)) {
                return redirect()->back()->with('error', 'From date cannot be after To date.');
            }

            // Build query
            $query = Attendance::with(['employee', 'geofence'])
                ->where('admin_id', $adminId)
                ->whereBetween('date', [$fromDate, $toDate]);

            // Filter by geofence if selected
            if ($request->filled('geofence')) {
                $query->where('geofence_id', $request->geofence);
            }

            // Filter by employee name if provided
            if ($request->filled('employee_name')) {
                $query->whereHas('employee', function ($q) use ($request, $adminId) {
                    $q->where('admin_id', $adminId)
                        ->where('name', 'like', '%' . $request->employee_name . '%');
                });
            }

            $attendances = $query->orderBy('date', 'desc')
                ->orderBy('check_in', 'desc')
                ->get();
        }

        return view('admin.attendance.delete', compact('attendances', 'fromDate', 'toDate', 'geofences', 'selectedGeofence'));
    }

    public function bulkDeleteAttendances(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $adminId = auth()->guard('admin')->id();

        // Build delete query
        $query = Attendance::where('admin_id', $adminId)
            ->whereBetween('date', [$request->from_date, $request->to_date]);

        // Filter by geofence if selected
        if ($request->filled('geofence')) {
            $query->where('geofence_id', $request->geofence);
        }

        // Filter by employee name if provided
        if ($request->filled('employee_name')) {
            $query->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)
                    ->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        $count = $query->count();
        $query->delete();

        return redirect()->route('admin.attendances.delete')
            ->with('success', "Successfully deleted {$count} attendance record(s).");
    }
}
