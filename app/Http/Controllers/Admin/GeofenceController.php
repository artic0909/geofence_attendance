<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Geofence;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;

class GeofenceController extends Controller
{


    public static function middleware(): array
    {
        return [
            new Middleware('admin'), // applies "admin" middleware to all actions
        ];
    }


    public function index(Request $request)
    {
        $query = Geofence::where('admin_id', auth()->guard('admin')->id());

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $geofences = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        return view('admin.geofences.index', compact('geofences'));
    }

    public function create()
    {
        return view('admin.geofences.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:50',
            'address' => 'required|string',
        ]);

        Geofence::create($request->all());

        return redirect()->route('admin.geofences.index')->with('success', 'Geofence created successfully.');
    }

    public function edit(Geofence $geofence)
    {
        return view('admin.geofences.edit', compact('geofence'));
    }

    public function update(Request $request, Geofence $geofence)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:50',
            'address' => 'required|string',
        ]);

        $geofence->update($request->all());

        return redirect()->route('admin.geofences.index')->with('success', 'Geofence updated successfully.');
    }

    public function destroy(Geofence $geofence)
    {
        $geofence->delete();
        return redirect()->route('admin.geofences.index')->with('success', 'Geofence deleted successfully.');
    }
}
