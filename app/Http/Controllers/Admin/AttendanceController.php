<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Geofence;
use App\Models\OutsideAttendance;
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
                ->count() + OutsideAttendance::where('admin_id', $adminId)
                ->whereDate('date', today())
                ->count(),
            'active_employees' => Employee::where('admin_id', $adminId)
                ->where('is_active', true)
                ->count(),
        ];

        // Base query for Normal Attendance
        $normalQuery = Attendance::with(['employee', 'geofence'])
            ->where('admin_id', $adminId);

        // Base query for Outside Attendance
        $outsideQuery = OutsideAttendance::with(['employee'])
            ->where('admin_id', $adminId);

        // Apply filters to both
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $normalQuery->whereBetween('date', [$request->from_date, $request->to_date]);
            $outsideQuery->whereBetween('date', [$request->from_date, $request->to_date]);
        } elseif ($request->filled('from_date')) {
            $normalQuery->whereDate('date', '>=', $request->from_date);
            $outsideQuery->whereDate('date', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $normalQuery->whereDate('date', '<=', $request->to_date);
            $outsideQuery->whereDate('date', '<=', $request->to_date);
        }

        if ($request->filled('employee_name')) {
            $normalQuery->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)->where('name', 'like', '%' . $request->employee_name . '%');
            });
            $outsideQuery->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        // Geofence filter only applies to Normal Attendance
        if ($request->filled('geofence')) {
            $normalQuery->where('geofence_id', $request->geofence);
        }

        // Fetch and Merge
        $normalRecords = $normalQuery->get()->map(function($a) { $a->attendance_type = 'normal'; return $a; });
        $outsideRecords = $outsideQuery->get()->map(function($a) { $a->attendance_type = 'outside'; return $a; });

        $merged = $normalRecords->concat($outsideRecords)->sortByDesc('date')->values();

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

        return view('admin.attendance.index', compact('stats', 'recent_attendances', 'geofences'));
    }

    public function export(Request $request)
    {
        $adminId = auth()->guard('admin')->id();

        // Base query - Normal
        $normalQuery = Attendance::with(['employee', 'geofence'])
            ->where('admin_id', $adminId);

        // Base query - Outside
        $outsideQuery = OutsideAttendance::with(['employee'])
            ->where('admin_id', $adminId);

        // Filters
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $normalQuery->whereBetween('date', [$request->from_date, $request->to_date]);
            $outsideQuery->whereBetween('date', [$request->from_date, $request->to_date]);
        } elseif ($request->filled('from_date')) {
            $normalQuery->whereDate('date', '>=', $request->from_date);
            $outsideQuery->whereDate('date', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $normalQuery->whereDate('date', '<=', $request->to_date);
            $outsideQuery->whereDate('date', '<=', $request->to_date);
        }

        if ($request->filled('employee_name')) {
            $employeeFilter = function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)->where('name', 'like', '%' . $request->employee_name . '%');
            };
            $normalQuery->whereHas('employee', $employeeFilter);
            $outsideQuery->whereHas('employee', $employeeFilter);
        }

        if ($request->filled('geofence')) {
            $normalQuery->where('geofence_id', $request->geofence);
        }

        $attendances = $normalQuery->get()->map(function($a){ $a->attendance_type = 'normal'; return $a; })
            ->concat($outsideQuery->get()->map(function($a){ $a->attendance_type = 'outside'; return $a; }))
            ->sortByDesc('date');

        $csvFileName = 'attendances_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($attendances) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Type', 'Name', 'Email', 'Date', 'Check In', 'Check Out', 'Total Hours', 'Location/Reason']);

            foreach ($attendances as $attendance) {
                $checkIn = $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in) : null;
                $checkOut = $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out) : null;
                
                $totalHours = 'N/A';
                if ($checkIn && $checkOut) {
                    $totalHours = $checkIn->diff($checkOut)->format('%H:%I:%S');
                }

                $location = $attendance->attendance_type == 'normal' 
                    ? ($attendance->geofence->name ?? 'N/A') 
                    : ($attendance->checkin_location ?? $attendance->reason ?? 'Outside');

                fputcsv($file, [
                    ucfirst($attendance->attendance_type),
                    $attendance->employee->name ?? 'N/A',
                    $attendance->employee->email ?? 'N/A',
                    \Carbon\Carbon::parse($attendance->date)->format('d/m/Y'),
                    $checkIn ? $checkIn->format('h:i A') : 'N/A',
                    $checkOut ? $checkOut->format('h:i A') : 'N/A',
                    $totalHours,
                    $location
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
                ->count() + OutsideAttendance::where('admin_id', $adminId)
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
                ->count() + OutsideAttendance::where('admin_id', $adminId)
                ->whereDate('date', today())
                ->count(),
            'active_employees' => Employee::where('admin_id', $adminId)
                ->where('is_active', true)
                ->count(),
        ];

        // Queries for today
        $normalQuery = Attendance::with(['employee', 'geofence'])
            ->where('admin_id', $adminId)
            ->whereDate('date', today());

        $outsideQuery = OutsideAttendance::with(['employee'])
            ->where('admin_id', $adminId)
            ->whereDate('date', today());

        if ($request->filled('geofence')) {
            $normalQuery->where('geofence_id', $request->geofence);
        }

        if ($request->filled('employee_name')) {
            $normalQuery->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)->where('name', 'like', '%' . $request->employee_name . '%');
            });
            $outsideQuery->whereHas('employee', function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        $merged = $normalQuery->get()->map(function($a){ $a->attendance_type = 'normal'; return $a; })
            ->concat($outsideQuery->get()->map(function($a){ $a->attendance_type = 'outside'; return $a; }))
            ->sortByDesc('check_in')->values();

        $page = $request->get('page', 1);
        $perPage = 15;
        $recent_attendances = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.attendance.today', compact('stats', 'recent_attendances', 'geofences'));
    }

    public function todayExport(Request $request)
    {
        $adminId = auth()->guard('admin')->id();

        // Base query - Normal
        $normalRecords = Attendance::with(['employee', 'geofence'])
            ->where('admin_id', $adminId)
            ->whereDate('date', today())
            ->get()->map(function($a){ $a->attendance_type = 'normal'; return $a; });

        // Base query - Outside
        $outsideRecords = OutsideAttendance::with(['employee'])
            ->where('admin_id', $adminId)
            ->whereDate('date', today())
            ->get()->map(function($a){ $a->attendance_type = 'outside'; return $a; });

        $attendances = $normalRecords->concat($outsideRecords)->sortByDesc('check_in');

        $csvFileName = 'todays_attendances_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($attendances) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'Type',
                'Name', 
                'Email', 
                'Date', 
                'Check In', 
                'Check Out', 
                'Total Hours', 
                'Location/Reason'
            ]);

            foreach ($attendances as $attendance) {
                $checkIn = $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in) : null;
                $checkOut = $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out) : null;
                
                $totalHours = 'N/A';
                if ($checkIn && $checkOut) {
                    $totalHours = $checkIn->diff($checkOut)->format('%H:%I:%S');
                }

                $location = $attendance->attendance_type == 'normal' 
                    ? ($attendance->geofence->name ?? 'N/A') 
                    : ($attendance->checkin_location ?? $attendance->reason ?? 'Outside');

                fputcsv($file, [
                    ucfirst($attendance->attendance_type),
                    $attendance->employee->name ?? 'N/A',
                    $attendance->employee->email ?? 'N/A',
                    \Carbon\Carbon::parse($attendance->date)->format('d/m/Y'),
                    $checkIn ? $checkIn->format('h:i A') : 'N/A',
                    $checkOut ? $checkOut->format('h:i A') : 'N/A',
                    $totalHours,
                    $location
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
            $normalQuery = Attendance::with(['employee', 'geofence'])
                ->where('admin_id', $adminId)
                ->whereBetween('date', [$fromDate, $toDate]);

            $outsideQuery = OutsideAttendance::with(['employee'])
                ->where('admin_id', $adminId)
                ->whereBetween('date', [$fromDate, $toDate]);

            // Filter by geofence if selected
            if ($request->filled('geofence')) {
                $normalQuery->where('geofence_id', $request->geofence);
                $outsideQuery->whereRaw('1 = 0');
            }

            // Filter by employee name if provided
            if ($request->filled('employee_name')) {
                $employeeFilter = function ($q) use ($request, $adminId) {
                    $q->where('admin_id', $adminId)->where('name', 'like', '%' . $request->employee_name . '%');
                };
                $normalQuery->whereHas('employee', $employeeFilter);
                $outsideQuery->whereHas('employee', $employeeFilter);
            }

            $attendances = $normalQuery->get()->map(function($a){ $a->attendance_type = 'normal'; return $a; })
                ->concat($outsideQuery->get()->map(function($a){ $a->attendance_type = 'outside'; return $a; }))
                ->sortByDesc('date');
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

        // Build delete query for Normal Attendance
        $normalQuery = Attendance::where('admin_id', $adminId)
            ->whereBetween('date', [$request->from_date, $request->to_date]);

        // Build delete query for Outside Attendance
        $outsideQuery = OutsideAttendance::where('admin_id', $adminId)
            ->whereBetween('date', [$request->from_date, $request->to_date]);

        // Filter by geofence if selected (only affects Normal Attendance)
        if ($request->filled('geofence')) {
            $normalQuery->where('geofence_id', $request->geofence);
            // If geofence is specified, we DON'T delete outside attendances 
            // because they are never tied to a geofence.
            $outsideQuery->whereRaw('1 = 0');
        }

        // Filter by employee name if provided
        if ($request->filled('employee_name')) {
            $employeeFilter = function ($q) use ($request, $adminId) {
                $q->where('admin_id', $adminId)
                    ->where('name', 'like', '%' . $request->employee_name . '%');
            };
            $normalQuery->whereHas('employee', $employeeFilter);
            $outsideQuery->whereHas('employee', $employeeFilter);
        }

        $count = $normalQuery->count() + $outsideQuery->count();
        $normalQuery->delete();
        $outsideQuery->delete();

        return redirect()->route('admin.attendances.delete')
            ->with('success', "Successfully deleted {$count} attendance record(s).");
    }
}
