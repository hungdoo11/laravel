<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $sentData;

    public function __construct($sentData)
    {
        $this->sentData = $sentData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('dduynam1@gmail.com', 'From Hung'),
            replyTo: [
                new Address('dduynam1@gmail.com', 'To Hung'),
            ],
            subject: 'Yêu cầu cấp lại mật khẩu từ Shop Bánh',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.interfaceEmail',
            with: [
                'sentData' => $this->sentData,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }


    // Mail::to($email)->send(new SendMail($sentData));
}
