<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailIntro extends Mailable
{
    use Queueable, SerializesModels;

    private $givenName;
    private $surName;
    private $insertion;
    private $paymentStatus;

    /**
     * Create a new message instance.
     *
     * @param $firstName
     * @param $lastName
     * @param $insertion
     * @param $paymentStatus
     */
    public function __construct($firstName, $lastName, $insertion, $paymentStatus)
    {
        $this->givenName = $firstName;
        $this->surName = $lastName;
        $this->insertion = $insertion;
        $this->paymentStatus = $paymentStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): SendMailIntro
    {
        return $this
                ->subject("Inschrijving intro")
                ->markdown('mail/introMail',['firstName'=> $this->givenName,'lastName'=>$this->surName,'insertion'=>$this->insertion, 'paymentStatus'=>$this->paymentStatus]);
    }
}
