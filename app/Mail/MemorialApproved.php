<?php

namespace App\Mail;

use App\Models\EmailContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemorialApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $memorial;

    public function __construct($memorial)
    {
        $this->memorial = $memorial;
    }

    public function build()
    {

        $content = EmailContent::where('key', 'memorial_approved')->firstOrFail();

        return $this->subject($content->subject)
            ->view('emails.memorial_approved')
            ->with([
                'memorialTitle' => $this->memorial->title,
                'content' => $content
            ]);
    }
}
