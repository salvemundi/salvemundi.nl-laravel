<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $givenName;
    private $surName;
    private $insertion;

    /**
     * Create a new message instance.
     *
     * @param $firstName
     * @param $lastName
     * @param $insertion
     */
    public function __construct($firstName, $lastName, $insertion, $paymentStatus)
    {
        $this->givenName = $firstName;
        $this->surName = $lastName;
        $this->insertionn = $insertion;
        $this->paymentStatus = $paymentStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): SendMail
    {
        return $this
                ->subject("Inschrijving intro")
                ->markdown('introMail',['firstName'=> $this->givenName,'lastName'=>$this->surName,'insertion'=>$this->insertionn, 'paymentStatus'=>$this->paymentStatus]);
    }
}
