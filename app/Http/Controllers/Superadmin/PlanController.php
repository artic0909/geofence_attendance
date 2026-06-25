<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $query = Plan::query()->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $plans = $query->paginate(10)->withQueryString();
        
        return view('superadmin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('superadmin.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string', // comma separated
            'active' => 'boolean',
            'is_popular' => 'boolean',
        ]);

        if ($request->has('features') && !empty($request->features)) {
            $validated['features'] = array_map('trim', explode(',', $request->features));
        } else {
            $validated['features'] = [];
        }

        $validated['active'] = $request->has('active');
        $validated['is_popular'] = $request->has('is_popular');

        Plan::create($validated);

        return redirect()->route('superadmin.plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        return view('superadmin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'active' => 'boolean',
            'is_popular' => 'boolean',
        ]);

        if ($request->has('features') && !empty($request->features)) {
            $validated['features'] = array_map('trim', explode(',', $request->features));
        } else {
            $validated['features'] = [];
        }
        
        $validated['active'] = $request->has('active');
        $validated['is_popular'] = $request->has('is_popular');

        $plan->update($validated);

        return redirect()->route('superadmin.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('superadmin.plans.index')->with('success', 'Plan deleted successfully.');
    }
}
