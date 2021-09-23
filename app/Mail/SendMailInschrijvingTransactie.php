<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailInschrijvingTransactie extends Mailable
{
    use Queueable, SerializesModels;
    private $givenName;
    private $surName;
    private $insertion;
    private $paymentLink;
    /**
     * Create a new message instance.
     *
     * @param $firstName
     * @param $lastName
     * @param $insertion
     * @param $paymentLink
     */
    public function __construct($firstName, $lastName, $insertion, $paymentLink)
    {
        $this->givenName = $firstName;
        $this->surName = $lastName;
        $this->insertion = $insertion;
        $this->paymentLink = $paymentLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Inschrijving Salve Mundi")
            ->markdown('mail/InschrijvingTransactie',['firstName'=> $this->givenName,'lastName'=>$this->surName,'insertion'=>$this->insertion, 'paymentLink' => $this->paymentLink]);
    }
}
