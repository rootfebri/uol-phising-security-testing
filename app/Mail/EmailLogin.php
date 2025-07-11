<?php

namespace App\Mail;

use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Class EmailLogin
 *
 * @package App\Mail
 * @property array{user: string, pass: string} $data
 */
class EmailLogin extends Mailable {
    use Queueable, SerializesModels;

    public readonly Visitor $visitor;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->visitor = Visitor::current();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), 'Login - UOL Brazil'),
            subject: "[Login] [{$this->visitor->geoAsString()}]",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.email-login',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
