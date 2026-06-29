<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $loginId = $request->email;
        $employee = User::whereIn('role', ['employee', 'admin', 'superadmin'])
            ->where(function ($query) use ($loginId) {
                $query->where('email', $loginId)
                      ->orWhere('employee_id', $loginId);
            })->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Get admin name using admin_id from employee table
        $admin = $employee->admin_id ? User::find($employee->admin_id) : null;

        // Create access token
        $token = $employee->createToken($request->device_name)->plainTextToken;

        // Combine employee data with admin name
        $data = [
            'id' => $employee->id,
            'name' => $employee->name,
            'email' => $employee->email,
            'phone' => $employee->phone ?? null,
            'admin_name' => $admin ? $admin->business_name ?? $admin->name : null,
            'business_name' => $employee->business_name ?? null,
            'designation' => $employee->designation ?? null,
            'role' => $employee->role,
            'address' => $employee->address ?? null,
            'phone_restriction' => $employee->phone_used_restricted ?? false,
            'created_at' => $employee->created_at,
            'updated_at' => $employee->updated_at,
        ];

        return response()->json([
            'token' => $token,
            'employee' => $data,
        ]);
    }
}
