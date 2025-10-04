<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Geofence;
use Illuminate\Routing\Controllers\HasMiddleware;
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
    public function index()
    {
        $employees = Employee::where('admin_id', auth()->guard('admin')->id())->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $geofences = Geofence::where('is_active', true)
            ->where('admin_id', auth()->guard('admin')->id())
            ->get();

        return view('admin.employees.create', compact('geofences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:employees,email',
            'phone'       => 'required|string|max:20',
            'employee_id' => 'required|string|max:50',
            'password'    => 'required|string|min:6',
            'geofences'   => 'nullable|array',
        ]);

        $employee = Employee::create([
            'admin_id'    => auth()->guard('admin')->id(),
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'employee_id' => $request->employee_id,
            'password'    => Hash::make($request->password),
        ]);

        // Sync geofences (only if provided)
        if ($request->filled('geofences')) {
            $employee->geofences()->sync($request->geofences);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        // Ensure admin can only edit their own employees
        $this->authorizeEmployee($employee);

        $geofences = Geofence::where('is_active', true)
            ->where('admin_id', auth()->guard('admin')->id())
            ->get();

        return view('admin.employees.edit', compact('employee', 'geofences'));
    }

    public function update(Request $request, Employee $employee)
    {
        // Security check
        $this->authorizeEmployee($employee);

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:employees,email,' . $employee->id,
            'phone'       => 'required|string|max:20',
            'employee_id' => 'required|string|max:50',
            'password'    => 'nullable|string|min:6',
            'geofences'   => 'nullable|array',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'employee_id']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        if ($request->filled('geofences')) {
            $employee->geofences()->sync($request->geofences);
        }

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        // Prevent one admin from deleting another’s employee
        $this->authorizeEmployee($employee);

        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    /**
     * Ensure logged-in admin owns the employee.
     */
    protected function authorizeEmployee(Employee $employee)
    {
        if ($employee->admin_id !== auth()->guard('admin')->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
