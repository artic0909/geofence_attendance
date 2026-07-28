<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('superadmin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.coupon.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:coupons,name|max:255',
            'no_of_employee' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
        ]);

        Coupon::create($request->all());

        return redirect()->route('superadmin.coupons.index')->with('success', 'Coupon created successfully.');
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
        $coupon = Coupon::findOrFail($id);
        return view('superadmin.coupon.create-edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:coupons,name,' . $coupon->id,
            'no_of_employee' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
        ]);

        $coupon->update($request->all());

        return redirect()->route('superadmin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('superadmin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
