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
        $query = User::where('role', 'admin')
            ->with('activeSubscription')
            ->withCount(['employees', 'geofences'])
            ->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('filter') && $request->filter != '') {
            $filter = $request->filter;
            if ($filter == 'active') {
                $query->where('subscription_status', 'active')
                      ->where('subscription_expires_at', '>=', now());
            } elseif ($filter == 'expiring_soon') {
                $query->where('subscription_status', 'active')
                      ->where('subscription_expires_at', '>=', now())
                      ->where('subscription_expires_at', '<=', now()->addDays(3));
            } elseif ($filter == 'expired') {
                $query->where(function($q) {
                    $q->where('subscription_status', 'expired')
                      ->orWhere('subscription_expires_at', '<', now());
                });
            }
        }

        $organizations = $query->paginate(10)->withQueryString();

        return view('superadmin.organization.index', compact('organizations'));
    }

    public function needInform(Request $request)
    {
        $query = User::where('role', 'admin')
            ->with('activeSubscription')
            ->withCount(['employees', 'geofences'])
            ->where('subscription_status', 'active')
            ->where('subscription_expires_at', '>=', now())
            ->where('subscription_expires_at', '<=', now()->addDays(3))
            ->latest();

        $organizations = $query->paginate(10)->withQueryString();
        return view('superadmin.organization.need-inform', compact('organizations'));
    }

    public function expired(Request $request)
    {
        $query = User::where('role', 'admin')
            ->with('activeSubscription')
            ->withCount(['employees', 'geofences'])
            ->where(function($q) {
                $q->where('subscription_status', 'expired')
                  ->orWhere('subscription_expires_at', '<', now());
            })
            ->latest();

        $organizations = $query->paginate(10)->withQueryString();
        return view('superadmin.organization.expired', compact('organizations'));
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

    /**
     * Apply a coupon to the specified organization.
     */
    public function applyCoupon(Request $request, string $id)
    {
        $organization = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'coupon_code' => 'required|string|exists:coupons,name',
        ]);

        $coupon = \App\Models\Coupon::where('name', $request->coupon_code)->firstOrFail();

        $startsAt = now();
        $expiresAt = now()->addDays($coupon->duration);

        // Deactivate previous active subscriptions for this user
        \App\Models\Subscription::where('user_id', $organization->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        // Create new subscription based on coupon
        \App\Models\Subscription::create([
            'user_id' => $organization->id,
            'plan_name' => $coupon->name,
            'employee_count' => $coupon->no_of_employee,
            'price' => 0.00,
            'duration_days' => $coupon->duration,
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
            'status' => 'active',
        ]);

        // Update organization's subscription status
        $organization->update([
            'subscription_status' => 'active',
            'subscription_expires_at' => $expiresAt,
        ]);

        return redirect()->route('superadmin.organizations.index')->with('success', 'Coupon applied successfully. Subscription updated.');
    }
}
