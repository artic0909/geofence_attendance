<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Geofence;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin'),
        ];
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'employee')->where('admin_id', auth()->id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        $employees = $query->with(['employeeGeofences', 'department', 'designation'])->orderBy('name', 'asc')->paginate(10)->withQueryString();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $geofences = Geofence::where('is_active', true)
            ->where('admin_id', auth()->id())
            ->get();
            
        $departments = \App\Models\Department::where('admin_id', auth()->id())->get();
        $designations = \App\Models\Designation::where('admin_id', auth()->id())->get();

        return view('admin.employees.create', compact('geofences', 'departments', 'designations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'phone'       => 'required|string|max:20',
            'employee_id' => 'required|string|max:50',
            'password'    => 'required|string|min:6',
            'geofences'   => 'nullable|array',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
        ]);

        $employee = User::create([
            'role'        => 'employee',
            'admin_id'    => auth()->id(),
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'employee_id' => $request->employee_id,
            'password'    => Hash::make($request->password),
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'phone_used_restricted' => $request->has('phone_used_restricted'),
        ]);

        if ($request->filled('geofences')) {
            $employee->employeeGeofences()->sync($request->geofences);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(User $employee)
    {
        $geofences = Geofence::where('is_active', true)
            ->where('admin_id', auth()->id())
            ->get();
            
        $departments = \App\Models\Department::where('admin_id', auth()->id())->get();
        $designations = \App\Models\Designation::where('admin_id', auth()->id())->get();

        return view('admin.employees.edit', compact('employee', 'geofences', 'departments', 'designations'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $employee->id,
            'phone'       => 'required|string|max:20',
            'employee_id' => 'required|string|max:50',
            'password'    => 'nullable|string|min:6',
            'geofences'   => 'nullable|array',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'employee_id', 'department_id', 'designation_id']);
        $data['phone_used_restricted'] = $request->has('phone_used_restricted');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        if ($request->filled('geofences')) {
            $employee->employeeGeofences()->sync($request->geofences);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function track(User $employee)
    {
        $attendance = \App\Models\Attendance::with('geofence')->where('employee_id', $employee->id)
            ->whereDate('date', now())
            ->whereNotNull('check_in')
            ->whereNull('check_out')
            ->first();

        if (!$attendance) {
            $attendance = \App\Models\OutsideAttendance::where('employee_id', $employee->id)
                ->whereDate('date', now())
                ->whereNotNull('check_in')
                ->whereNull('check_out')
                ->first();
                
            if ($attendance) {
                $attendance->attendance_type = 'outside';
            }
        }

        // Load geofences for this employee to show them on the map
        $employee->load('employeeGeofences');
        
        return view('admin.employees.track', compact('employee', 'attendance'));
    }

    public function getLatestLocation(User $employee)
    {
        $location = \App\Models\EmployeeLocation::where('employee_id', $employee->id)->first();
        
        if ($location) {
            // Check if the location is "stale" (optional, but good for UX)
            // if ($location->updated_at->diffInMinutes(now()) > 5) {
            //     return response()->json(['status' => 'offline']);
            // }

            return response()->json([
                'latitude' => (float)$location->latitude,
                'longitude' => (float)$location->longitude,
                'updated_at' => $location->updated_at->toIso8601String(),
                'diff_minutes' => $location->updated_at->diffInMinutes(now())
            ]);
        }
        
        return response()->json(['error' => 'No data found'], 404);
    }
}
