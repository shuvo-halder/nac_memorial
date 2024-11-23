<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class SetRecaptchaKeys
{
    public function handle($request, Closure $next)
    {
        $siteKey = DB::table('settings')->where('name', 'recaptcha_site_key')->value('value');
        $secretKey = DB::table('settings')->where('name', 'recaptcha_secret_key')->value('value');

        config(['captcha.sitekey' => $siteKey, 'captcha.secret' => $secretKey]);

        return $next($request);
    }
}
