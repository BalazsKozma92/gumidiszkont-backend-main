<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $confirmationToken;
    public $name;
    public $verificationUrl;
    /**
     * Create a new message instance.
     */
    public function __construct($confirmationToken, $name, $verificationUrl)
    {
        $this->confirmationToken = $confirmationToken;
        $this->name = $name;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@gumidiszkont.hu', 'noreply'),
            subject: 'Regisztráció',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_registered',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
