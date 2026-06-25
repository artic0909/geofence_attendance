<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('superadmin.settings.index');
    }

    public function update(Request $request)
    {
        // Simple update logic for future
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
