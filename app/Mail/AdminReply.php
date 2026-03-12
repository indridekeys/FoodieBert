<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminReply extends Mailable
{
    use Queueable, SerializesModels;

    public $replyMessage;
    public $originalSubject;

    // 1. Receive the data from the Controller
    public function __construct($replyMessage, $originalSubject)
    {
        $this->replyMessage = $replyMessage;
        $this->originalSubject = $originalSubject;
    }

    // 2. Set the Subject Line
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: ' . $this->originalSubject,
        );
    }

    // 3. Point to a real Blade view (we will create this next)
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_reply', 
        );
    }
}
