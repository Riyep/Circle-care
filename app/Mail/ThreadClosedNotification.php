<?php

namespace App\Mail;

use App\Models\MtIssue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThreadClosedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $issue;

    public function __construct(MtIssue $issue)
    {
        $this->issue = $issue;
    }

    public function build()
    {
        return $this->subject('Thread Telah Ditutup')
                    ->view('emails.thread_closed');
    }
}
