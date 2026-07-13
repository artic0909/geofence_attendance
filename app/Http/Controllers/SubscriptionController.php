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
        $user = auth()->user();
        $currentEmployees = $user ? $user->employees()->count() : 0;
        
        return view('subscription.select-plan', compact('plans', 'currentEmployees'));
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'employee_count' => 'nullable|integer|min:0',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = auth()->user();
        $currentEmployees = $user ? $user->employees()->count() : 0;
        $minEmployees = max($plan->employee_count ?? 10, $currentEmployees);
        
        $employeeCount = $request->employee_count ?? $minEmployees;
        
        // Enforce backend validation just in case they bypass JS
        if ($employeeCount < $minEmployees) {
            $employeeCount = $minEmployees;
        }
        
        if ($plan->is_trial) {
            $hasTrial = Transaction::where('user_id', auth()->id())
                ->where('status', 'successful')
                ->whereHas('plan', function($q) {
                    $q->where('is_trial', true);
                })->exists();

            if ($hasTrial) {
                return response()->json(['success' => false, 'message' => 'You have already claimed a trial pack.'], 403);
            }

            $amount = 2; // Trigger Razorpay for 2 INR for trial
        } else {
            $baseAmount = $plan->price + ($plan->price_per_employee * $employeeCount);
            $gstAmount = $baseAmount * 0.18;
            $amount = $baseAmount + $gstAmount;
        }
        
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $order = $api->order->create([
                'receipt'         => 'order_rcptid_' . time(),
                'amount'          => $amount * 100, // amount in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ]);

            // We need a way to pass employee_count to verifyPayment.
            // We can temporarily store it in the session based on order_id.
            session(['order_employee_count_'.$order['id'] => $employeeCount]);

            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $amount * 100,
                'is_trial' => false,
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

        $plan = Plan::findOrFail($request->plan_id);
        $employeeCount = session('order_employee_count_'.$request->razorpay_order_id, $plan->employee_count ?? 10);
        
        if ($plan->is_trial) {
            $hasTrial = Transaction::where('user_id', auth()->id())
                ->where('status', 'successful')
                ->whereHas('plan', function($q) {
                    $q->where('is_trial', true);
                })->exists();

            if ($hasTrial) {
                return response()->json(['success' => false, 'message' => 'You have already claimed a trial pack.'], 403);
            }
            $amount = 2;
            $gstAmount = 0;
        } else {
            $baseAmount = $plan->price + ($plan->price_per_employee * $employeeCount);
            $gstAmount = $baseAmount * 0.18;
            $amount = $baseAmount + $gstAmount;
        }

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
        } catch (\Exception $e) {
            Log::error('Razorpay Signature Verification Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Payment verification failed'], 400);
        }

        try {
            // Prevent duplicate transaction processing using atomic locks
            $lock = \Illuminate\Support\Facades\Cache::lock('payment_process_'.$request->razorpay_payment_id, 10);
            
            if (!$lock->get()) {
                return response()->json(['success' => true, 'redirect_url' => route('admin.dashboard')]);
            }

            $existingTransaction = Transaction::where('razorpay_payment_id', $request->razorpay_payment_id)->first();
            if ($existingTransaction) {
                $lock->release();
                return response()->json(['success' => true, 'redirect_url' => route('admin.dashboard')]);
            }

            // Payment is successful or Trial activated
            $user = Auth::user();

            // Record transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'amount' => $amount,
                'gst_amount' => $gstAmount,
                'currency' => 'INR',
                'status' => 'successful',
                'employee_count' => $employeeCount,
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
                'employee_count' => $employeeCount,
                'starts_at' => Carbon::now(),
                'expires_at' => $expiresAt,
                'status' => 'active',
            ]);

            $user->update([
                'plan_id' => $plan->id,
                'subscription_status' => 'active',
                'subscription_expires_at' => $expiresAt,
            ]);

            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\InvoiceMail($transaction));
            } catch (\Exception $mailException) {
                Log::error('Failed to send invoice email: ' . $mailException->getMessage());
            }

            $lock->release();

            return response()->json(['success' => true, 'redirect_url' => route('admin.dashboard')]);
        } catch (\Exception $e) {
            Log::error('Transaction creation failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to activate subscription'], 500);
        }
    }
}
