<?php

namespace App\Console\Commands;

use App\Models\Materias\RedatorAleatorio;
use Illuminate\Console\Command;

class RefreshMaterias extends Command
{

    protected $signature = 'refresh_materias';
    protected $description = 'RefreshMaterias';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $assuntos = RedatorAleatorio::all();
        // foreach $assuntos as $assunto {

        //     if($assunto->data_leitura > 3days )
        // }
    }
}
