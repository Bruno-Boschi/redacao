<?php

namespace App\Console\Commands;

use App\Models\Materias\RedatorAleatorio;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $assuntos = RedatorAleatorio::leftJoin('users', 'users.id', '=', 'redator_aleatorio.usuario_id')
            ->select('redator_aleatorio.*', 'users.name as usuario_name', 'users.email as usuario_email')
            ->get();

        $data = Carbon::now()->subDay(3);
        $data2 = Carbon::now()->subDay(2);


        foreach ($assuntos as $assunto) {

            if ($assunto->status == 3 && $assunto->data_leitura < $data) {
                Log::channel('RefreshMateria')->info('Iniciando Refresh');
                Log::channel('RefreshMateria')->info('Assunto ID:' . $assunto->id . ' esta vencido ');
                $assunto->status = 0;
                $assunto->usuario_id = 0;
                $assunto->data_leitura = null;
                $assunto->save();
                Mail::send(new \App\Mail\expDemanda($assunto));
                Log::channel('RefreshMateria')->info('Assunto ID:' . $assunto->id . ' atualizado para status 0 (enviado)');
            }
                  if($assunto->status == 3 && $assunto->data_leitura <= $data2){
                    Mail::send(new \App\Mail\vencDemanda($assunto));
            }
        }
    }
}
