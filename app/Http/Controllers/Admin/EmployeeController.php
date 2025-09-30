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
            new Middleware('admin'), // applies "admin" middleware to all actions
        ];
    }
    public function index()
    {
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $geofences = Geofence::where('is_active', true)->get();
        return view('admin.employees.create', compact('geofences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:employees,email',
            'phone'       => 'required|string|max:20',
            'employee_id' => 'required|string|max:50|unique:employees,employee_id',
            'password'    => 'required|string|min:6',
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'employee_id' => $request->employee_id,
            'password' => Hash::make($request->password),
        ]);

        // Sync geofences
        $employee->geofences()->sync($request->geofences);

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $geofences = Geofence::where('is_active', true)->get();
        return view('admin.employees.edit', compact('employee', 'geofences'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:employees,email,' . $employee->id,
            'phone'       => 'required|string|max:20',
            'employee_id' => 'required|string|max:50|unique:employees,employee_id,' . $employee->id,
            'password'    => 'nullable|string|min:6',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'employee_id']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        $employee->geofences()->sync($request->geofences);

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
