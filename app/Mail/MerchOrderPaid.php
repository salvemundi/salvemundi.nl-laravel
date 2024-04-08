<?php

namespace App\Mail;

use App\Enums\MerchGender;
use App\Models\Merch;
use App\Models\MerchSize;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MerchOrderPaid extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Merch $merch;
    public MerchSize $size;
    public MerchGender $gender;
    public Transaction $transaction;
    public ?string $note = null;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Merch $merch, MerchSize $size, MerchGender $gender, Transaction $transaction, string $note = null)
    {
        $this->user = $user;
        $this->merch = $merch;
        $this->size = $size;
        $this->gender = $gender;
        $this->transaction = $transaction;
        $this->note = $note ?? $this->note;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@salvemundi.nl', 'Salve Mundi'),
            subject: 'Bestelling ontvangen',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.MerchOrderPaid',
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
