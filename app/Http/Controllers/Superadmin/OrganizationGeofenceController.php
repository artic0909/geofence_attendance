<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Geofence;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationGeofenceController extends Controller
{
    public function index(Request $request, $organization)
    {
        $org = User::findOrFail($organization);
        
        $query = Geofence::where('admin_id', $org->id);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $geofences = $query->paginate(10);

        return view('superadmin.organization.geofences.index', compact('org', 'geofences'));
    }

    public function create($organization)
    {
        $org = User::findOrFail($organization);
        return view('superadmin.organization.geofences.create', compact('org'));
    }

    public function store(Request $request, $organization)
    {
        $org = User::findOrFail($organization);

        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            'status' => 'boolean',
            'lunch_start_time' => 'nullable|date_format:H:i',
            'lunch_end_time' => 'nullable|date_format:H:i|after:lunch_start_time',
        ]);

        Geofence::create([
            'admin_id' => $org->id,
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'status' => $request->has('status') ? $request->status : true,
            'lunch_start_time' => $request->lunch_start_time,
            'lunch_end_time' => $request->lunch_end_time,
        ]);

        return redirect()->route('superadmin.organizations.geofences.index', $org->id)
                         ->with('success', 'Geofence created successfully.');
    }

    public function edit($organization, $geofenceId)
    {
        $org = User::findOrFail($organization);
        $geofence = Geofence::where('admin_id', $org->id)->findOrFail($geofenceId);
        
        return view('superadmin.organization.geofences.edit', compact('org', 'geofence'));
    }

    public function update(Request $request, $organization, $geofenceId)
    {
        $org = User::findOrFail($organization);
        $geofence = Geofence::where('admin_id', $org->id)->findOrFail($geofenceId);

        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            'status' => 'boolean',
            'lunch_start_time' => 'nullable|date_format:H:i',
            'lunch_end_time' => 'nullable|date_format:H:i|after:lunch_start_time',
        ]);

        $geofence->update([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'status' => $request->has('status') ? $request->status : false,
            'lunch_start_time' => $request->lunch_start_time,
            'lunch_end_time' => $request->lunch_end_time,
        ]);

        return redirect()->route('superadmin.organizations.geofences.index', $org->id)
                         ->with('success', 'Geofence updated successfully.');
    }

    public function destroy($organization, $geofenceId)
    {
        $org = User::findOrFail($organization);
        $geofence = Geofence::where('admin_id', $org->id)->findOrFail($geofenceId);
        
        $geofence->delete();

        return redirect()->route('superadmin.organizations.geofences.index', $org->id)
                         ->with('success', 'Geofence deleted successfully.');
    }
}
