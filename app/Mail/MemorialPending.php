<?php

namespace App\Mail;

use App\Models\EmailContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemorialPending extends Mailable
{
    use Queueable, SerializesModels;

    public $memorial;

    public function __construct($memorial)
    {
        $this->memorial = $memorial;
    }

    public function build()
    {

        $content = EmailContent::where('key', 'memorial_panding')->firstOrFail();

        return $this->subject('Your Memorial is Pending Validation')
            ->view('emails.memorial_pending')
            ->with([
                'memorialTitle' => $this->memorial->title,
                'content' => $content
            ]);
    }
}
