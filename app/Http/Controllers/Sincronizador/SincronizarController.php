<?php

namespace App\Http\Controllers\Sincronizador;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\Models\Materias\RedatorAleatorio;
use App\Models\Configuracoes\Configuracoes;
use App\User;
use App\Models\Dominios\Dominios;
use App\Models\Dominios\FaturamentoDominio;

class SincronizarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Factory $validator) {
        $this->request = $request;
        $this->validator = $validator;
    }

    public function show($id)
    {
        
    }

    public function anySelecionarRedatorAutomatico($tipo)
    {
        date_default_timezone_set('America/Sao_Paulo');
        if ($tipo == 'redator') {
            $redatores = RedatorAleatorio::orderBy('updated_at', 'desc')->whereIn('status', array(0, 1))->get();
            $configuracoes = Configuracoes::find(1);
            $intervaloTroca = getDate(strtotime($configuracoes->tempo_rejeitar_materia));
            $intervaloTroca = $intervaloTroca["hours"].$intervaloTroca["minutes"];
            
            if (!empty($configuracoes->tempo_rejeitar_materia)) {
                foreach ($redatores as $redator) {
                    $dataAssuntoInicial = new \DateTime(date('Y-m-d H:i', $redator->updated_at->timestamp));
                    $dataAtual = new \DateTime(date('Y-m-d H:i'));
                    $intervalo = $dataAssuntoInicial->diff($dataAtual);
                    $intervalo = $intervalo->h.$intervalo->i;
                    
                    if ($intervalo > $intervaloTroca) {
                        $proximoRedator = $this->proximoRedatorSelecionado($redator->usuario_id);
                        $alterarRedator = RedatorAleatorio::find($redator->id);
                        $alterarRedator->usuario_id = $proximoRedator;
                        $alterarRedator->data_leitura = null;
                        $alterarRedator->status = 0;
                        $alterarRedator->save();
                    }
                }
            }
        }
    }
    
    private function proximoRedatorSelecionado($usuarioId)
    {
        $usuario = User::where('id', '>', $usuarioId)
            ->where('ativo', '=', '1')
            ->where('tipo_usuario', '=', 'R')
            ->orderBy('id', 'asc')
            ->first();
        if (empty($usuario)) {
            $usuario = User::where('ativo', '=', '1')
                ->where('tipo_usuario', '=', 'R')
                ->orderBy('id', 'asc')
                ->first();
        }
        return $usuario->id;
    }
    
    public function anyRelatorioFaturamento($tipo)
    {
        date_default_timezone_set('America/Sao_Paulo');
        if ($tipo == 'faturamento') {
            $dominios = Dominios::all();
            foreach ($dominios as $dominio) {
                $url = str_replace("https://","",$dominio->dominio);
                $url = str_replace("http://","",$url);
                $url = 'https://office.joinads.me/run/api/informationkey/2831b400-e0c2-4f1f-81b5-42faa03ea723/'.$url;

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                
                $response = curl_exec($ch);
                curl_close($ch);
                $dados = json_decode($response);
                
                if (!empty($dados)) {
                    $totalRegistro = FaturamentoDominio::where('dominio_id','=', $dados[0]->id_domain)->count();
                    if ($totalRegistro > 0) {
                        FaturamentoDominio::where('dominio_id', '=', $dominio->id)->delete();
                    }
                    foreach ($dados as $dado) {
                        $faturamento = new FaturamentoDominio;
                        $faturamento->impressoes = $dado->impressions;
                        $faturamento->cliques = $dado->clicks;
                        $faturamento->valor_impressao = $dado->earnings;
                        $faturamento->data_busca = $dado->date;
                        $faturamento->id_wordpress = $dado->url_id;
                        $faturamento->dominio_id = $dominio->id;
                        $faturamento->id_domain = $dado->id_domain;
                        $faturamento->save();
                    }
                }
            }
        }
        
    }
}