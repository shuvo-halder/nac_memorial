<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('frontend.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, FlasherInterface $flasher)
    {
        $request->validate([
            'email' => 'required|email',
            // 'g-recaptcha-response' => 'required|captcha'
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        $successMessage = DB::table('success_messages')
            ->where('key', 'reset_password_message')
            ->value('message');


        if ($status == Password::RESET_LINK_SENT) {
            $flasher->addInfo($successMessage, 'Reset Password', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);

            return back()->with('status', __($status));
        } else {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
        }
    }
}
