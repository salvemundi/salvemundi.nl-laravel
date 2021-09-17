<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\WhatsappLink;

class SendMailInschrijving extends Mailable
{
    use Queueable, SerializesModels;

    private $givenName;
    private $surName;
    private $insertion;
    private $paymentStatus;
    private $pass;
    private $email;

    /**
     * Create a new message instance.
     *
     * @param $firstName
     * @param $lastName
     * @param $insertion
     * @param $paymentStatus
     * @param $pass
     */
    public function __construct($firstName, $lastName, $insertion, $paymentStatus, $pass, $email = null)
    {
        $this->givenName = $firstName;
        $this->surName = $lastName;
        $this->insertion = $insertion;
        $this->paymentStatus = $paymentStatus;
        $this->pass = $pass;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): SendMailInschrijving
    {
        $whatsappLink = WhatsappLink::all();
        return $this
                ->subject("Inschrijving Salve Mundi")
                ->markdown('mail/inschrijfMail',['firstName'=> $this->givenName,'lastName'=>$this->surName,'insertion'=>$this->insertion, 'paymentStatus' => $this->paymentStatus,'pass' => $this->pass, 'whatsappLink' => $whatsappLink,'email' => $this->email]);
    }
}
