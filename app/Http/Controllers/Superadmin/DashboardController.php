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
            'total_revenue' => Transaction::whereIn('status', ['paid', 'successful', 'completed'])->sum('amount'),
            'recent_transactions' => Transaction::with('user', 'plan')->latest()->take(5)->get(),
        ];
        
        // Month-wise Revenue Data for current year
        $transactionsThisYear = Transaction::whereIn('status', ['paid', 'successful', 'completed'])
            ->whereYear('created_at', date('Y'))
            ->get(['amount', 'created_at']);
            
        $revenueData = array_fill(0, 12, 0);
        foreach ($transactionsThisYear as $transaction) {
            $monthIndex = $transaction->created_at->format('n') - 1; // 0 for Jan, 11 for Dec
            $revenueData[$monthIndex] += $transaction->amount;
        }
        $stats['revenue_data'] = $revenueData;

        // Month-wise Organization Registration Data for current year
        $orgsThisYear = User::where('role', 'admin')
            ->whereYear('created_at', date('Y'))
            ->get(['created_at']);
            
        $orgsData = array_fill(0, 12, 0);
        foreach ($orgsThisYear as $org) {
            $monthIndex = $org->created_at->format('n') - 1;
            $orgsData[$monthIndex]++;
        }
        $stats['orgs_data'] = $orgsData;
        
        return view('superadmin.dashboard.index', compact('stats'));
    }
}
