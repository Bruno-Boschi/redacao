<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class redatorEspecifico extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($redator)
    {
        //          
        $this->redator = $redator;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Solicitação de Materiais');
        $this->to($this->redator->email, $this->redator->name);
        return $this->markdown('mail.redatorEspecifico', [
            'redator' => $this->redator,
        ]);
    }
}
