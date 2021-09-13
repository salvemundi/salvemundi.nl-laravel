<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailActivitySignUp extends Mailable
{
    use Queueable, SerializesModels;
    private $activity;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject("Inschrijving ".$this->activity)
                ->markdown('mail/inschrijfMailActiviteit',['activity'=> $this->activity]);
    }
}
