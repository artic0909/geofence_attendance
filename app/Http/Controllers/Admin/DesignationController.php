<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::where('admin_id', Auth::id())->latest()->paginate(10);
        return view('admin.designations.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.designations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        Designation::create([
            'name' => $request->name,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.designations.index')->with('success', 'Designation created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $designation = Designation::where('admin_id', Auth::id())->findOrFail($id);
        return view('admin.designations.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $designation = Designation::where('admin_id', Auth::id())->findOrFail($id);
        $designation->update(['name' => $request->name]);

        return redirect()->route('admin.designations.index')->with('success', 'Designation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designation = Designation::where('admin_id', Auth::id())->findOrFail($id);
        $designation->delete();

        return redirect()->route('admin.designations.index')->with('success', 'Designation deleted successfully.');
    }
}
