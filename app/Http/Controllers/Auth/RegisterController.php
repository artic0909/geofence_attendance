<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'gst_number' => ['nullable', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:20'],
            'business_type' => ['required', 'string', 'max:100'],
            'other_business_type' => ['required_if:business_type,Others', 'nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Combine first and last name
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        unset($validated['first_name']);
        unset($validated['last_name']);

        // Handle 'Others' business type
        if ($validated['business_type'] === 'Others' && !empty($validated['other_business_type'])) {
            $validated['business_type'] = $validated['other_business_type'];
        }
        unset($validated['other_business_type']);

        // lowercase email
        $validated['email'] = strtolower($validated['email']);

        // hash password
        $validated['password'] = Hash::make($validated['password']);
        
        // set role as admin by default for self-registrations
        $validated['role'] = 'admin';

        $user = User::create($validated);

        auth()->login($user);

        // Redirect to plan selection instead of dashboard
        return redirect()->route('pricing.select')->with('success', 'Registration successful! Please select a plan to continue.');
    }
}
