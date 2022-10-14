<?php

namespace App\Console\Commands;

use App\Models\Materias\RedatorAleatorio;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        $data = Carbon::now()->subDay(3);

        foreach ($assuntos as $assunto) {
            if ($assunto->status == 3 && $assunto->data_leitura < $data) {
                Log::channel('RefreshMateria')->info('Iniciando Refresh');
                Log::channel('RefreshMateria')->info('Assunto ID:' . $assunto->id . ' esta vencido ');
                $assunto->status = 0;
                $assunto->usuario_id = 0;
                $assunto->data_leitura = null;
                $assunto->save();
                Log::channel('RefreshMateria')->info('Assunto ID:' . $assunto->id . ' atualizado para status 0 (enviado)');
            }
        }
    }
}
