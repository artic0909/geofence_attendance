<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $employee = Employee::where('email', $request->email)->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Get admin name using admin_id from employee table
        $admin = $employee->admin_id ? Admin::find($employee->admin_id) : null;

        // Create access token
        $token = $employee->createToken($request->device_name)->plainTextToken;

        // Combine employee data with admin name
        $data = [
            'id' => $employee->id,
            'name' => $employee->name,
            'email' => $employee->email,
            'phone' => $employee->phone ?? null,
            'admin_name' => $admin ? $admin->name : null,
            'designation' => $employee->designation ?? null,
            'address' => $employee->address ?? null,
            'created_at' => $employee->created_at,
            'updated_at' => $employee->updated_at,
        ];

        return response()->json([
            'token' => $token,
            'employee' => $data,
        ]);
    }
}
