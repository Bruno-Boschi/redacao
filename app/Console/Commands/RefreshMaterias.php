<?php

namespace App\Console\Commands;

use App\Models\Materias\RedatorAleatorio;
use App\User;
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
            //condição de demanda preste a expirar
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
            
            //condição de demanda  vencida
            if($assunto->status == 3 && $assunto->data_leitura <= $data2){
            Mail::send(new \App\Mail\vencDemanda($assunto));
            }
             
            //condição de demanda em espera para redator especifico 
            if($assunto->status == 0 && $assunto->usuario_id != 0){
                $user = User::find($assunto->usuario_id);
            Mail::send(new \App\Mail\redatorEspecifico($user));
            }

               
        }
        //condição de demanda livre, onde todos os redatores podem aceitar
        $solicitacoesEspecifica = RedatorAleatorio::where('usuario_id', 0)
            ->select('count(*) as allcount')
            ->count();

        $users = User::where('tipo_usuario','R')
                ->where('ativo','!=', 0)
                ->get();

        if($solicitacoesEspecifica){
                foreach ($users as $user) {
                   Mail::send(new \App\Mail\redatorAleatorio($user));
                }
        }
    }
}
