<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Geofence;
use App\Models\Attendance;
use App\Models\OutsideAttendance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $adminId = auth()->id();
        $selectedMonth = $request->input('month', 'all');
        $selectedYear = $request->input('year', 'all');

        // Available Months list
        $monthsList = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        // Available Years (distinct from attendances, outside_attendances, and current year)
        $yearsSet = [date('Y')];
        $attYears = Attendance::where('admin_id', $adminId)->select('date')->distinct()->pluck('date');
        foreach ($attYears as $d) {
            if ($d) {
                $yearsSet[] = Carbon::parse($d)->format('Y');
            }
        }
        $outYears = OutsideAttendance::where('admin_id', $adminId)->select('date')->distinct()->pluck('date');
        foreach ($outYears as $d) {
            if ($d) {
                $yearsSet[] = Carbon::parse($d)->format('Y');
            }
        }
        $availableYears = array_values(array_unique($yearsSet));
        rsort($availableYears);

        // Determine filter state and label
        $isFiltered = false;
        $filterLabel = 'All Time';

        if ($selectedMonth !== 'all' && $selectedYear !== 'all') {
            $isFiltered = true;
            $filterLabel = ($monthsList[$selectedMonth] ?? 'Month') . ' ' . $selectedYear;
        } elseif ($selectedYear !== 'all' && $selectedMonth === 'all') {
            $isFiltered = true;
            $filterLabel = 'Year ' . $selectedYear . ' (All Months)';
        } elseif ($selectedMonth !== 'all' && $selectedYear === 'all') {
            $isFiltered = true;
            $filterLabel = ($monthsList[$selectedMonth] ?? 'Month') . ' (All Years)';
        }

        // 1. Core Employee Stats
        $totalEmployees = User::where('role', 'employee')->where('admin_id', $adminId)->count();
        $activeEmployees = User::where('role', 'employee')->where('admin_id', $adminId)->where('is_active', true)->count();
        $inactiveEmployees = max(0, $totalEmployees - $activeEmployees);
        $totalGeofences = Geofence::where('admin_id', $adminId)->count();
        $totalDepartments = Department::where('admin_id', $adminId)->count();
        $totalDesignations = Designation::where('admin_id', $adminId)->count();

        // 2. Today's Live Stats
        $todayInside = Attendance::where('admin_id', $adminId)->whereDate('date', today())->count();
        $todayOutside = OutsideAttendance::where('admin_id', $adminId)->whereDate('date', today())->count();
        $todayAttendances = $todayInside + $todayOutside;

        $attendedEmployeeIdsToday = Attendance::where('admin_id', $adminId)
            ->whereDate('date', today())
            ->pluck('employee_id')
            ->concat(
                OutsideAttendance::where('admin_id', $adminId)
                    ->whereDate('date', today())
                    ->pluck('employee_id')
            )
            ->unique();

        $todayAbsents = User::where('role', 'employee')
            ->where('admin_id', $adminId)
            ->where('is_active', true)
            ->whereNotIn('id', $attendedEmployeeIdsToday)
            ->count();

        $todayRate = $activeEmployees > 0 ? round(($todayAttendances / $activeEmployees) * 100, 1) : 0;

        // 3. Period / Filtered Attendance Stats
        $attendanceQuery = Attendance::where('admin_id', $adminId);
        $outsideAttendanceQuery = OutsideAttendance::where('admin_id', $adminId);
        $transactionQuery = Transaction::where('user_id', $adminId)->whereIn('status', ['paid', 'successful', 'completed']);

        if ($selectedYear !== 'all') {
            $attendanceQuery->whereYear('date', (int)$selectedYear);
            $outsideAttendanceQuery->whereYear('date', (int)$selectedYear);
            $transactionQuery->whereYear('created_at', (int)$selectedYear);
        }
        if ($selectedMonth !== 'all') {
            $attendanceQuery->whereMonth('date', (int)$selectedMonth);
            $outsideAttendanceQuery->whereMonth('date', (int)$selectedMonth);
            $transactionQuery->whereMonth('created_at', (int)$selectedMonth);
        }

        $periodInsideCount = $attendanceQuery->count();
        $periodOutsideCount = $outsideAttendanceQuery->count();
        $periodTotalAttendance = $periodInsideCount + $periodOutsideCount;
        $periodPayments = $transactionQuery->sum('amount');

        // Check-outs completed in period
        $periodInsideCheckoutCount = (clone $attendanceQuery)->whereNotNull('check_out')->count();
        $periodOutsideCheckoutCount = (clone $outsideAttendanceQuery)->whereNotNull('check_out')->count();
        $periodTotalCheckouts = $periodInsideCheckoutCount + $periodOutsideCheckoutCount;
        $checkoutCompletionRate = $periodTotalAttendance > 0 ? round(($periodTotalCheckouts / $periodTotalAttendance) * 100, 1) : 0;

        // Auto-checkout traps count
        $periodTrapCount = (clone $attendanceQuery)->where('is_auto_checkout_trap', true)->count() 
            + (clone $outsideAttendanceQuery)->where('is_auto_checkout_trap', true)->count();

        // 4. Subscription Progress Calculation
        $current_plan = auth()->user()->activeSubscription;
        $subscription = [
            'days_left' => 0,
            'percentage' => 100,
            'is_expired' => true,
        ];

        if (auth()->user()->subscription_expires_at) {
            $endDate = Carbon::parse(auth()->user()->subscription_expires_at);
            $now = now();
            $daysLeft = number_format($now->floatDiffInDays($endDate, false), 2, '.', '');
            
            if ($daysLeft > 0) {
                $latestTx = Transaction::where('user_id', $adminId)
                    ->whereIn('status', ['paid', 'successful', 'completed'])
                    ->latest()
                    ->first();
                $startDate = $latestTx ? $latestTx->created_at : auth()->user()->created_at;
                $totalDays = max(1, $startDate->diffInDays($endDate));
                $passedDays = max(0, $startDate->diffInDays($now));
                $percentage = min(100, ($passedDays / $totalDays) * 100);
                
                $subscription = [
                    'days_left' => $daysLeft,
                    'percentage' => $percentage,
                    'is_expired' => false,
                ];
            }
        }

        // 5. Chart 1: Attendance Trends (Timeline Chart)
        $trendLabels = [];
        $trendInside = [];
        $trendOutside = [];
        $trendAbsent = [];
        $trendTotal = [];

        if ($selectedMonth !== 'all' && $selectedYear !== 'all') {
            // Day by Day for the selected Month & Year
            $daysInMonth = Carbon::createFromDate((int)$selectedYear, (int)$selectedMonth, 1)->daysInMonth;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $dayCarbon = Carbon::createFromDate((int)$selectedYear, (int)$selectedMonth, $d);
                $currentDate = $dayCarbon->format('Y-m-d');
                $trendLabels[] = $dayCarbon->format('d M');
                
                $inCount = Attendance::where('admin_id', $adminId)->whereDate('date', $currentDate)->count();
                $outCount = OutsideAttendance::where('admin_id', $adminId)->whereDate('date', $currentDate)->count();
                $presentCount = $inCount + $outCount;
                $absentCount = max(0, $activeEmployees - $presentCount);

                $trendInside[] = $inCount;
                $trendOutside[] = $outCount;
                $trendAbsent[] = $absentCount;
                $trendTotal[] = $presentCount;
            }
        } elseif ($selectedYear !== 'all' && $selectedMonth === 'all') {
            // Month by Month for the selected Year (Jan - Dec)
            for ($m = 1; $m <= 12; $m++) {
                $mCarbon = Carbon::createFromDate((int)$selectedYear, $m, 1);
                $trendLabels[] = $mCarbon->format('M');

                $inCount = Attendance::where('admin_id', $adminId)->whereYear('date', (int)$selectedYear)->whereMonth('date', $m)->count();
                $outCount = OutsideAttendance::where('admin_id', $adminId)->whereYear('date', (int)$selectedYear)->whereMonth('date', $m)->count();
                $presentCount = $inCount + $outCount;

                $trendInside[] = $inCount;
                $trendOutside[] = $outCount;
                $trendTotal[] = $presentCount;
                $trendAbsent[] = max(0, ($activeEmployees * 26) - $presentCount);
            }
        } else {
            // Last 12 Months Trend (All Time Overview)
            for ($i = 11; $i >= 0; $i--) {
                $mDate = now()->subMonths($i);
                $trendLabels[] = $mDate->format('M Y');

                $inCount = Attendance::where('admin_id', $adminId)->whereYear('date', $mDate->year)->whereMonth('date', $mDate->month)->count();
                $outCount = OutsideAttendance::where('admin_id', $adminId)->whereYear('date', $mDate->year)->whereMonth('date', $mDate->month)->count();
                $presentCount = $inCount + $outCount;

                $trendInside[] = $inCount;
                $trendOutside[] = $outCount;
                $trendTotal[] = $presentCount;
                $trendAbsent[] = max(0, ($activeEmployees * 26) - $presentCount);
            }
        }

        // 6. Chart 2: Attendance Method & Status Breakdown
        $methodLabels = ['On-Site (Geofence)', 'Outside / Field Duty', 'Auto-Checkout Trap'];
        $methodData = [$periodInsideCount, $periodOutsideCount, $periodTrapCount];

        // 7. Chart 3: Geofence / Site Attendance Distribution
        $geofences = Geofence::where('admin_id', $adminId)
            ->withCount(['attendances' => function ($q) use ($selectedYear, $selectedMonth) {
                if ($selectedYear !== 'all') {
                    $q->whereYear('date', (int)$selectedYear);
                }
                if ($selectedMonth !== 'all') {
                    $q->whereMonth('date', (int)$selectedMonth);
                }
            }, 'employees'])
            ->get();

        $geofenceLabels = [];
        $geofenceData = [];
        foreach ($geofences as $geo) {
            $geofenceLabels[] = $geo->name;
            $geofenceData[] = $geo->attendances_count;
        }

        // 8. Chart 4: Department-wise Employee & Attendance Distribution
        $departments = Department::where('admin_id', $adminId)->with(['employees'])->get();
        $deptLabels = [];
        $deptEmployeeCounts = [];
        $deptAttendanceCounts = [];

        foreach ($departments as $dept) {
            $deptLabels[] = $dept->name;
            $deptEmpIds = $dept->employees->pluck('id');
            $deptEmployeeCounts[] = $deptEmpIds->count();

            $deptAttQuery = Attendance::where('admin_id', $adminId)->whereIn('employee_id', $deptEmpIds);
            $deptOutQuery = OutsideAttendance::where('admin_id', $adminId)->whereIn('employee_id', $deptEmpIds);
            if ($selectedYear !== 'all') {
                $deptAttQuery->whereYear('date', (int)$selectedYear);
                $deptOutQuery->whereYear('date', (int)$selectedYear);
            }
            if ($selectedMonth !== 'all') {
                $deptAttQuery->whereMonth('date', (int)$selectedMonth);
                $deptOutQuery->whereMonth('date', (int)$selectedMonth);
            }
            $deptAttendanceCounts[] = $deptAttQuery->count() + $deptOutQuery->count();
        }

        // 9. Chart 5: Peak Arrival / Hourly Punch-In Distribution
        $hourBuckets = [
            'Before 8 AM' => 0,
            '8 AM - 9 AM' => 0,
            '9 AM - 10 AM' => 0,
            '10 AM - 11 AM' => 0,
            '11 AM - 12 PM' => 0,
            '12 PM - 2 PM' => 0,
            'After 2 PM' => 0,
        ];

        $checkInsQuery = Attendance::where('admin_id', $adminId)->whereNotNull('check_in');
        $outCheckInsQuery = OutsideAttendance::where('admin_id', $adminId)->whereNotNull('check_in');
        if ($selectedYear !== 'all') {
            $checkInsQuery->whereYear('date', (int)$selectedYear);
            $outCheckInsQuery->whereYear('date', (int)$selectedYear);
        }
        if ($selectedMonth !== 'all') {
            $checkInsQuery->whereMonth('date', (int)$selectedMonth);
            $outCheckInsQuery->whereMonth('date', (int)$selectedMonth);
        }
        $checkInTimes = $checkInsQuery->pluck('check_in')->concat($outCheckInsQuery->pluck('check_in'));
        foreach ($checkInTimes as $t) {
            if ($t) {
                $hr = Carbon::parse($t)->hour;
                if ($hr < 8) $hourBuckets['Before 8 AM']++;
                elseif ($hr === 8) $hourBuckets['8 AM - 9 AM']++;
                elseif ($hr === 9) $hourBuckets['9 AM - 10 AM']++;
                elseif ($hr === 10) $hourBuckets['10 AM - 11 AM']++;
                elseif ($hr === 11) $hourBuckets['11 AM - 12 PM']++;
                elseif ($hr >= 12 && $hr < 14) $hourBuckets['12 PM - 2 PM']++;
                else $hourBuckets['After 2 PM']++;
            }
        }

        // 10. Chart 6: Designation Distribution
        $designations = Designation::where('admin_id', $adminId)->withCount('employees')->get();
        $designationLabels = [];
        $designationCounts = [];
        foreach ($designations as $desig) {
            $designationLabels[] = $desig->name;
            $designationCounts[] = $desig->employees_count;
        }

        // 11. Recent Live Check-In Activity (Combined Normal & Outside)
        $recentNormal = Attendance::where('admin_id', $adminId)
            ->with(['employee.department', 'geofence'])
            ->latest('check_in')
            ->take(8)
            ->get()
            ->map(function ($item) {
                $item->type = 'inside';
                return $item;
            });

        $recentOutside = OutsideAttendance::where('admin_id', $adminId)
            ->with(['employee.department'])
            ->latest('check_in')
            ->take(8)
            ->get()
            ->map(function ($item) {
                $item->type = 'outside';
                return $item;
            });

        $recentActivities = $recentNormal->concat($recentOutside)
            ->sortByDesc('check_in')
            ->take(8);

        // 12. Consolidate Stats Object
        $stats = [
            'total_employees' => $totalEmployees,
            'active_employees' => $activeEmployees,
            'inactive_employees' => $inactiveEmployees,
            'total_geofences' => $totalGeofences,
            'total_departments' => $totalDepartments,
            'total_designations' => $totalDesignations,
            'today_attendances' => $todayAttendances,
            'today_inside' => $todayInside,
            'today_outside' => $todayOutside,
            'today_absents' => $todayAbsents,
            'today_rate' => $todayRate,
            'period_total_attendance' => $periodTotalAttendance,
            'period_inside' => $periodInsideCount,
            'period_outside' => $periodOutsideCount,
            'period_checkouts' => $periodTotalCheckouts,
            'checkout_completion_rate' => $checkoutCompletionRate,
            'period_traps' => $periodTrapCount,
            'total_payments' => $periodPayments,
            
            // Charts Data
            'trend_labels' => $trendLabels,
            'trend_inside' => $trendInside,
            'trend_outside' => $trendOutside,
            'trend_absent' => $trendAbsent,
            'trend_total' => $trendTotal,

            'method_labels' => $methodLabels,
            'method_data' => $methodData,

            'geofence_labels' => $geofenceLabels,
            'geofence_data' => $geofenceData,

            'dept_labels' => $deptLabels,
            'dept_employees' => $deptEmployeeCounts,
            'dept_attendances' => $deptAttendanceCounts,

            'hour_labels' => array_keys($hourBuckets),
            'hour_data' => array_values($hourBuckets),

            'designation_labels' => $designationLabels,
            'designation_counts' => $designationCounts,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'geofences',
            'departments',
            'designations',
            'current_plan',
            'subscription',
            'monthsList',
            'availableYears',
            'selectedMonth',
            'selectedYear',
            'isFiltered',
            'filterLabel',
            'recentActivities'
        ));
    }

    public function exportPending(Request $request)
    {
        $adminId = auth()->id();

        // Get IDs of employees who have already given attendance today
        $attendedEmployeeIds = \App\Models\Attendance::where('admin_id', $adminId)
            ->whereDate('date', today())
            ->pluck('employee_id')
            ->concat(
                \App\Models\OutsideAttendance::where('admin_id', $adminId)
                    ->whereDate('date', today())
                    ->pluck('employee_id')
            )
            ->unique();

        // Fetch employees who have NOT given attendance today with their geofences
        $employees = \App\Models\User::with('employeeGeofences')
            ->where('role', 'employee')
            ->where('admin_id', $adminId)
            ->where('is_active', true)
            ->whereNotIn('id', $attendedEmployeeIds)
            ->orderBy('name', 'asc')
            ->get();

        $fileName = 'pending_attendance_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($employees) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['Employee Name', 'Email', 'Phone', 'Employee ID', 'Assigned Geofences', 'Status', 'Date']);

            foreach ($employees as $employee) {
                // Get geofence names
                $geofenceNames = $employee->employeeGeofences->pluck('name')->implode(', ');

                fputcsv($file, [
                    $employee->name,
                    $employee->email,
                    $employee->phone,
                    $employee->employee_id ?? 'N/A',
                    $geofenceNames ?: 'No Geofence Assigned',
                    'Absent / Not Checked In',
                    date('d/m/Y')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

