<?php

namespace App\Mail;

use App\Models\EmailContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {

        $content = EmailContent::where('key', 'otp')->firstOrFail();

        return $this->subject('Your OTP Code')
            ->view('emails.send-otp')
            ->with(['otp' => $this->otp, 'content' => $content]);
    }
}
