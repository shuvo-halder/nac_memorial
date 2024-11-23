<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;

class DisconnectionMessage
{
    public $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->guest()) {

            $successMessage = DB::table('success_messages')
                ->where('key', 'logout_message')
                ->value('message');

            $this->flasher->addInfo($successMessage, 'Success!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);
        }

        return $response;
    }
}
