<?php

namespace App\Mail;

use App\Models\MtIssue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class ThreadPostedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $issue;

    public function __construct(MtIssue $issue)
    {
        $this->issue = $issue;
    }

    public function build()
    {
        return $this->subject('Thread Baru Telah Dibuat')
                    ->view('emails.thread_posted');
    }
}
