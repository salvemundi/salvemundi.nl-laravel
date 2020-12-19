<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstName, $lastName, $insertion)
    {
        $this->givenName = $firstName;
        $this->surName = $lastName;
        $this->insertionn = $insertion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject("Inschrijving intro")
                ->markdown('introMail',['firstName'=> $this->givenName,'lastName'=>$this->surName,'insertion'=>$this->insertionn]);
    }
}
