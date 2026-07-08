<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgetpassword');
    }

    /**
     * Send OTP to the user's email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We could not find an account with that email address.'
        ]);

        $email = $request->email;
        
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Delete any existing reset tokens for this email
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Store the OTP (hashed for security, though plain is fine if short-lived, hashing is better practice)
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($otp),
            'created_at' => Carbon::now()
        ]);

        $user = User::where('email', $email)->first();

        // Send Email
        try {
            Mail::to($email)->send(new ResetPasswordOtpMail($otp, $user->name));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email. Please ensure mail settings are correct.'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent to your email successfully.'
        ]);
    }

    /**
     * Verify the OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return response()->json(['status' => 'error', 'message' => 'Invalid or expired OTP request.'], 400);
        }

        // Check if expired (15 minutes limit)
        if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return response()->json(['status' => 'error', 'message' => 'OTP has expired. Please request a new one.'], 400);
        }

        // Verify Hash
        if (!Hash::check($request->otp, $resetRecord->token)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid OTP entered.'], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified successfully.'
        ]);
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->otp, $resetRecord->token)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid or expired OTP.'], 400);
        }

        if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            return response()->json(['status' => 'error', 'message' => 'OTP has expired.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Clear the reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successfully. You can now login.'
        ]);
    }
}
