<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class solicitarPag extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($financeiro, $user)
    {
        //
        $this->financeiro = $financeiro;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {       
        $this->subject('Solicitação de Pagamento de Redator');
        $this->to($this->financeiro->email, $this->financeiro->name);
        return $this->markdown('mail.solicitarPag', [
            'user' => $this->user,
        ]);
    }
}
