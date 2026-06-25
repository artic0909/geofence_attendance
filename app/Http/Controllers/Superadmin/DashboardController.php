<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_organizations' => User::where('role', 'admin')->count(),
            'active_plans' => Plan::where('active', true)->count(),
            'total_revenue' => Transaction::where('status', 'paid')->sum('amount'),
            'recent_transactions' => Transaction::with('user', 'plan')->latest()->take(5)->get(),
        ];
        
        return view('superadmin.dashboard.index', compact('stats'));
    }
}
