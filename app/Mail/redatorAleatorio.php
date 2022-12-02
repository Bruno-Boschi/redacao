<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class redatorAleatorio extends Mailable
{
    use Queueable, SerializesModels;

     public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
        
    }
            
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $this->subject('Solicitação de Materia');
        $this->to($this->user->email, $this->user->name);
        return $this->markdown('mail.redatorAleatorio');
    }
}
