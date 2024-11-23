<?php

namespace App\Jobs;

use App\Mail\MemorialApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMemorialApprovalEmail implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    protected $memorial;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\Item  $memorial
     * @return void
     */
    public function __construct($memorial)
    {
        $this->memorial = $memorial;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->memorial->user->email)->send(new MemorialApproved($this->memorial));
    }
}

