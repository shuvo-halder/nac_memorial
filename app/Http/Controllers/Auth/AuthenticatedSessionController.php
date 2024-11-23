<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\SendOtpMail;
use App\Models\Otp;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('frontend.auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        $otpEnabled = Otp::where('user_id', $user->id)->where('is_active', true)->exists();

        if ($otpEnabled) {
            $otpKey = random_int(10000, 99999);

            Otp::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'otp_key' => $otpKey,
                    'exp_date' => now()->addMinutes(2),
                    'is_active' => true
                ]
            );

            Mail::to($user->email)->send(new SendOtpMail($otpKey));

            session(['otp_pending_user_id' => $user->id]);
            Auth::logout();

            return redirect()->route('otp.verify');
        }

        // Normal role-based redirection if OTP is not enabled
        $userRoles = $user->getRoleNames();
        if ($userRoles == collect(['admin'])) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }



    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
