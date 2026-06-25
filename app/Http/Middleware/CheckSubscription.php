<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            if ($user->subscription_status !== 'active' || Carbon::now()->greaterThan($user->subscription_expires_at)) {
                return redirect()->route('pricing.select')->with('error', 'Please subscribe to a plan to access the Organization Panel.');
            }
        }

        return $next($request);
    }
}
