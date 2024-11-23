<?php

use App\Models\User;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Mail\SendOtpMail;

Route::get('auth/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('socialite.redirect');

Route::get('auth/{provider}/callback', function (Request $request, $provider) {

    if (!$request->has('code')) {
        return redirect()->route('login')->with('error', 'Login with Google was canceled.');
    }

    try {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } else {
            $fullName = $socialUser->getName();
            $firstName = $fullName ? explode(' ', trim($fullName))[0] : 'Guest';

            $user = User::create([
                'name' => $firstName,
                'email' => $socialUser->getEmail(),
                'email_verified_at' => now(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'password' => bcrypt(Str::random(16)),
            ]);
        }

        $user->assignRole('user');

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

        Auth::login($user);

        return redirect()->route('index');
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'There was an error logging in with Google.');
    }
})->name('socialite.callback');
