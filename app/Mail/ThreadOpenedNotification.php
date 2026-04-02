<?php

namespace App\Mail;

use App\Models\MtIssue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThreadOpenedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $issue;

    public function __construct(MtIssue $issue)
    {
        $this->issue = $issue;
    }

    public function build()
    {
        return $this->subject('Thread Baru Telah Dibuka')
                    ->view('emails.thread_opened');
    }
}
