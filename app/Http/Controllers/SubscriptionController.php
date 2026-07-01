<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plan;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function selectPlan()
    {
        $plans = Plan::where('active', true)->get();
        return view('subscription.select-plan', compact('plans'));
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $amount = $plan->price;
        
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $order = $api->order->create([
                'receipt'         => 'order_rcptid_' . time(),
                'amount'          => $amount * 100, // amount in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $amount * 100,
                'key' => config('services.razorpay.key')
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
            'plan_id' => 'required|exists:plans,id',
        ]);

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
            
            // Payment is successful
            $user = Auth::user();
            $plan = Plan::findOrFail($request->plan_id);
            $amount = $plan->price;

            // Record transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'amount' => $amount,
                'currency' => 'INR',
                'status' => 'successful',
            ]);

            // Update user subscription
            $expiresAt = Carbon::now()->addDays($plan->duration_days);
            
            // Invalidate previous subscriptions
            Subscription::where('user_id', $user->id)->where('status', 'active')->update(['status' => 'expired']);

            // Create new snapshot subscription
            Subscription::create([
                'user_id' => $user->id,
                'transaction_id' => $transaction->id,
                'plan_name' => $plan->name,
                'features' => $plan->features,
                'price' => $amount,
                'duration_days' => $plan->duration_days,
                'starts_at' => Carbon::now(),
                'expires_at' => $expiresAt,
                'status' => 'active',
            ]);

            $user->update([
                'plan_id' => $plan->id,
                'subscription_status' => 'active',
                'subscription_expires_at' => $expiresAt,
            ]);

            return response()->json(['success' => true, 'redirect_url' => route('admin.dashboard')]);
        } catch (\Exception $e) {
            Log::error('Razorpay Signature Verification Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Payment verification failed'], 400);
        }
    }
}
