<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class expDemanda extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assunto)
    {
        //
        $this->assunto = $assunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Prazo Expirado');
        $this->to($this->assunto->usuario_email, $this->assunto->usuario_name);
        return $this->markdown('mail.expDemanda', [
            'assunto' => $this->assunto,
        ]);
    }
}
