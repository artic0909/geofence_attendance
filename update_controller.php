<?php
$content = file_get_contents('app/Http/Controllers/Admin/AttendanceController.php');

$search1 = <<<'EOD'
        if ($request->filled('geofence')) {
            $normalQuery->where('geofence_id', $request->geofence);
            $outsideQuery->whereRaw('1 = 0'); 
        }
EOD;

$replace1 = <<<'EOD'
        if ($request->filled('geofence')) {
            if ($request->geofence === 'outside') {
                $normalQuery->whereRaw('1 = 0');
            } else {
                $normalQuery->where('geofence_id', $request->geofence);
                $outsideQuery->whereRaw('1 = 0'); 
            }
        }
EOD;

$content = str_replace($search1, $replace1, $content);

$search2 = <<<'EOD'
        if ($request->filled('geofence')) {
            $normalQuery->where('geofence_id', $request->geofence);
            $outsideQuery->whereRaw('1 = 0');
        }
EOD;

$replace2 = <<<'EOD'
        if ($request->filled('geofence')) {
            if ($request->geofence === 'outside') {
                $normalQuery->whereRaw('1 = 0');
            } else {
                $normalQuery->where('geofence_id', $request->geofence);
                $outsideQuery->whereRaw('1 = 0');
            }
        }
EOD;

$content = str_replace($search2, $replace2, $content);

$search3 = <<<'EOD'
        if ($request->filled('geofence')) {
            $normalQuery->where('geofence_id', $request->geofence);
            // If geofence is specified, we DON'T delete outside attendances 
            // because they are never tied to a geofence.
            $outsideQuery->whereRaw('1 = 0');
        }
EOD;

$replace3 = <<<'EOD'
        if ($request->filled('geofence')) {
            if ($request->geofence === 'outside') {
                $normalQuery->whereRaw('1 = 0');
            } else {
                $normalQuery->where('geofence_id', $request->geofence);
                // If geofence is specified, we DON'T delete outside attendances 
                // because they are never tied to a geofence.
                $outsideQuery->whereRaw('1 = 0');
            }
        }
EOD;

$content = str_replace($search3, $replace3, $content);

$search_today_absent = <<<'EOD'
        // Apply filters if any
        if ($request->filled('employee_name')) {
            $pendingQuery->where('name', 'like', '%' . $request->employee_name . '%');
        }

        $pending_employees = $pendingQuery->with('employeeGeofences')->orderBy('name', 'asc')->paginate(10);

        return view('admin.attendance.today_absent', compact('pending_employees'));
EOD;

$replace_today_absent = <<<'EOD'
        // Get only this admin's geofences
        $geofences = Geofence::where('admin_id', $adminId)->get();

        // Apply filters if any
        if ($request->filled('employee_name')) {
            $pendingQuery->where('name', 'like', '%' . $request->employee_name . '%');
        }

        if ($request->filled('geofence')) {
            if ($request->geofence === 'outside') {
                $pendingQuery->whereRaw('1 = 0');
            } else {
                $pendingQuery->whereHas('employeeGeofences', function($q) use ($request) {
                    $q->where('geofence_id', $request->geofence);
                });
            }
        }

        $pending_employees = $pendingQuery->with('employeeGeofences')->orderBy('name', 'asc')->paginate(10);

        return view('admin.attendance.today_absent', compact('pending_employees', 'geofences'));
EOD;

$content = str_replace($search_today_absent, $replace_today_absent, $content);

file_put_contents('app/Http/Controllers/Admin/AttendanceController.php', $content);
echo "Updated Controller\n";
?>
