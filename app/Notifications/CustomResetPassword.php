<?php

namespace App\Notifications;

use App\Models\EmailContent;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomResetPassword extends ResetPasswordNotification
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Retrieve the custom email content from the database
        $content = EmailContent::where('key', 'password_reset')->firstOrFail();

        // Generate the reset URL
        $resetUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')),
            ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]
        );

        // Build the email message
        return (new MailMessage)
            ->subject($content->subject) // Dynamic subject
            ->view('emails.reset_password', [ // Use custom Blade view
                'resetUrl' => $resetUrl,
                'user' => $notifiable,
                'content' => $content, // Pass dynamic content
            ]);
    }
}
