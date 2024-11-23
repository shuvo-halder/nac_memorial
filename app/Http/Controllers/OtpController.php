<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function enableOtp()
    {
        $user = Auth::user();

        Otp::updateOrCreate(['user_id' => $user->id], [
            'user_id' => $user->id,
            'otp_key' => '00000',
            'exp_date' => now(),
            'is_active' => true,
        ]);

        return back();
    }

    public function disableOtp()
    {
        $user = Auth::user();

        Otp::updateOrCreate(['user_id' => $user->id], [
            'user_id' => $user->id,
            'otp_key' => '00000',
            'exp_date' => now(),
            'is_active' => false,
        ]);

        return back();
    }

    public function otpVerify()
    {
        return view('frontend.auth.otp-verify');
    }

    public function otpVerified(Request $request)
    {

        $request->validate(['otp' => 'required|string']);

        $userId = session('otp_pending_user_id');

        if (!$userId) {
            return redirect()->route('login')->withErrors(['otp' => 'Session expired. Please log in again.']);
        }

        $userOtpRecord = Otp::where('user_id', $userId)
            ->where('otp_key', $request->otp)
            ->where('is_active', true)
            ->where('exp_date', '>', now())
            ->first();

        if ($userOtpRecord) {
            Auth::loginUsingId($userId);

            session()->forget('otp_pending_user_id');

            $userRoles = Auth::user()->getRoleNames();
            if ($userRoles->contains('admin')) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        } else {
            return back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again.']);
        }
    }
}
