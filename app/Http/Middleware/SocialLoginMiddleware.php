<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use App\Models\Setting;

class SocialLoginMiddleware
{
    public function handle($request, Closure $next)
    {
        $settings = Setting::all()->pluck('value', 'name')->toArray();

        Config::set('services.google', [
            'client_id' => $settings['GOOGLE_CLIENT_ID'] ?? null,
            'client_secret' => $settings['GOOGLE_CLIENT_SECRET'] ?? null,
            'redirect' => $settings['GOOGLE_REDIRECT_URI'] ?? null,
        ]);

        Config::set('services.facebook', [
            'client_id' => $settings['FACEBOOK_CLIENT_ID'] ?? null,
            'client_secret' => $settings['FACEBOOK_CLIENT_SECRET'] ?? null,
            'redirect' => $settings['FACEBOOK_REDIRECT_URI'] ?? null,
        ]);

        return $next($request);
    }
}
