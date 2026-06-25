<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'admin')->withCount(['employees', 'geofences'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $organizations = $query->paginate(10)->withQueryString();

        return view('superadmin.organization.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $organization = User::where('role', 'admin')->findOrFail($id);
        return view('superadmin.organization.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $organization = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $organization->id,
            'phone' => 'nullable|string|max:20',
            'gst_number' => 'nullable|string|max:50',
            'address_line_1' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $organization->update([
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gst_number' => $request->gst_number,
            'address_line_1' => $request->address_line_1,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'is_active' => $request->has('is_active') ? $request->is_active : false,
        ]);

        if ($request->filled('password')) {
            $organization->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        return redirect()->route('superadmin.organizations.index')->with('success', 'Organization updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organization = User::where('role', 'admin')->findOrFail($id);
        
        // Delete related employees and geofences
        $organization->employees()->delete();
        $organization->geofences()->delete();
        
        $organization->delete();

        return redirect()->route('superadmin.organizations.index')->with('success', 'Organization deleted successfully.');
    }
}
