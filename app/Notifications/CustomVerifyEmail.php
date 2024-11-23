<?php

namespace App\Notifications;

use App\Models\EmailContent;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        $content = EmailContent::where('key', 'email_verify')->firstOrFail();


        return (new MailMessage)
            ->subject($content->subject)
            ->view('emails.verify', [
                'url' => $verificationUrl,
                'user' => $notifiable,
                'content' => $content
            ]);
    }

    /**
     * Generate the verification URL.
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }
}
