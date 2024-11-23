<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckOtpSession
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('otp_pending_user_id')) {
            return redirect()->route('login')->withErrors(['otp' => 'Access denied. Please log in to continue.']);
        }

        return $next($request);
    }
}
