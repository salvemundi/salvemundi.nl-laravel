<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Enums\MerchGender;
use App\Models\Merch;
use App\Models\MerchSize;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Mail\Mailables\Address;

class MerchPreOrderReceived extends Mailable
{
    use Queueable, SerializesModels;
    public User $user;
    public Merch $merch;
    public MerchSize $size;
    public MerchGender $gender;
    public Transaction $transaction;
    /**
     * Create a new message instance.
     */
     public function __construct(User $user, Merch $merch, MerchSize $size, MerchGender $gender, Transaction $transaction)
     {
         $this->user = $user;
         $this->merch = $merch;
         $this->size = $size;
         $this->gender = $gender;
         $this->transaction = $transaction;
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
            markdown: 'mail.MerchPreOrderReceived',
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
