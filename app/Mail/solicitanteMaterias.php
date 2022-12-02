<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class solicitanteMaterias extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($solicitante)
    {
        //
            $this->solicitante = $solicitante;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $this->subject('Artigos para avaliação');
        $this->to($this->solicitante->email, $this->solicitante->name);
        return $this->markdown('mail.solicitanteMaterias', [
            'solicitante' => $this->solicitante,
        ]);
    }
}
