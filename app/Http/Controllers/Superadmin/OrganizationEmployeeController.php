<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Geofence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class OrganizationEmployeeController extends Controller
{
    public function index(Request $request, $organization)
    {
        $org = User::findOrFail($organization);
        
        $query = User::where('admin_id', $org->id)
                     ->where('role', 'employee');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(10);

        return view('superadmin.organization.employees.index', compact('org', 'employees'));
    }

    public function create($organization)
    {
        $org = User::findOrFail($organization);
        $departments = Department::where('admin_id', $org->id)->get();
        $designations = Designation::where('admin_id', $org->id)->get();
        $geofences = Geofence::where('admin_id', $org->id)->get();
        
        return view('superadmin.organization.employees.create', compact('org', 'departments', 'designations', 'geofences'));
    }

    public function store(Request $request, $organization)
    {
        $org = User::findOrFail($organization);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'employee_id' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'is_active' => 'boolean',
            'geofences' => 'nullable|array',
            'geofences.*' => 'exists:geofences,id'
        ]);

        DB::beginTransaction();
        try {
            $employee = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'employee',
                'admin_id' => $org->id,
                'employee_id' => $request->employee_id,
                'phone' => $request->phone,
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id,
                'is_active' => $request->has('is_active') ? $request->is_active : true,
                'phone_used_restricted' => $request->has('phone_used_restricted') ? $request->phone_used_restricted : false,
            ]);

            if ($request->has('geofences')) {
                // Attach geofences via employeeGeofences table/relationship or sync
                // If it's a many-to-many relationship:
                $employee->employeeGeofences()->sync($request->geofences);
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating employee: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('superadmin.organizations.employees.index', $org->id)
                         ->with('success', 'Employee created successfully.');
    }

    public function edit($organization, $employeeId)
    {
        $org = User::findOrFail($organization);
        $employee = User::where('admin_id', $org->id)->where('role', 'employee')->findOrFail($employeeId);
        
        $departments = Department::where('admin_id', $org->id)->get();
        $designations = Designation::where('admin_id', $org->id)->get();
        $geofences = Geofence::where('admin_id', $org->id)->get();
        
        return view('superadmin.organization.employees.edit', compact('org', 'employee', 'departments', 'designations', 'geofences'));
    }

    public function update(Request $request, $organization, $employeeId)
    {
        $org = User::findOrFail($organization);
        $employee = User::where('admin_id', $org->id)->where('role', 'employee')->findOrFail($employeeId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($employee->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'employee_id' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'is_active' => 'boolean',
            'geofences' => 'nullable|array',
            'geofences.*' => 'exists:geofences,id'
        ]);

        DB::beginTransaction();
        try {
            $employee->name = $request->name;
            $employee->email = $request->email;
            if ($request->filled('password')) {
                $employee->password = Hash::make($request->password);
            }
            $employee->employee_id = $request->employee_id;
            $employee->phone = $request->phone;
            $employee->department_id = $request->department_id;
            $employee->designation_id = $request->designation_id;
            $employee->is_active = $request->has('is_active') ? $request->is_active : false;
            if ($request->has('phone_used_restricted')) {
                $employee->phone_used_restricted = $request->phone_used_restricted;
            } else {
                $employee->phone_used_restricted = false;
            }
            
            $employee->save();

            if ($request->has('geofences')) {
                $employee->employeeGeofences()->sync($request->geofences);
            } else {
                $employee->employeeGeofences()->sync([]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating employee: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('superadmin.organizations.employees.index', $org->id)
                         ->with('success', 'Employee updated successfully.');
    }

    public function destroy($organization, $employeeId)
    {
        $org = User::findOrFail($organization);
        $employee = User::where('admin_id', $org->id)->where('role', 'employee')->findOrFail($employeeId);
        
        $employee->delete();

        return redirect()->route('superadmin.organizations.employees.index', $org->id)
                         ->with('success', 'Employee deleted successfully.');
    }

    public function track($organization, $employeeId)
    {
        $org = User::findOrFail($organization);
        $employee = User::where('admin_id', $org->id)->where('role', 'employee')->findOrFail($employeeId);
        
        return view('superadmin.organization.employees.track', compact('org', 'employee'));
    }

    public function latestLocation($organization, $employeeId)
    {
        $org = User::findOrFail($organization);
        $employee = User::where('admin_id', $org->id)->where('role', 'employee')->findOrFail($employeeId);
        
        $location = \App\Models\EmployeeLocation::where('employee_id', $employee->id)->first();
        
        if ($location) {
            return response()->json([
                'latitude' => (float)$location->latitude,
                'longitude' => (float)$location->longitude,
                'updated_at' => $location->updated_at->format('h:i:s A - d/m/Y')
            ]);
        }
        
        return response()->json(['error' => 'No data found'], 404);
    }
}
