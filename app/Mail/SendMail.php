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
    public function __construct($firstName, $lastName)
    {
        $this->voorNaam = $firstName;
        $this->achterNaam = $lastName;
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
                ->markdown('introMail',['firstName'=> $this->voorNaam,'lastName'=>$this->achterNaam]);
    }
}
