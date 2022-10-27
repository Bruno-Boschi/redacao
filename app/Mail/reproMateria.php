<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class reproMateria extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($materia)
    {
        //
        $this->materia = $materia;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Matéria Reprovada');
        $this->to($this->materia->usuario_email, $this->materia->usuario_name);
        return $this->markdown('mail.reproMateria', [
            'materia' => $this->materia,
        ]);
    }
}
