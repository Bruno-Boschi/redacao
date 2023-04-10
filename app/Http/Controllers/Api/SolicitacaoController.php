<?php

namespace App\Http\Controllers\Api;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materias\RedatorAleatorio;
use App\Models\Dominios\Dominios;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Helpers\ImportadorDadosWordPress;

class SolicitacaoController extends Controller
{

    public function solicitacaoIntegra(Request $request)
    {
        // dd($request);
        // return response()->json([
        //   $request->all()
        // ]);

        // $dominios = DB::table('dominios')->get();
        $dominio = DB::table('dominios')->where('dominio', $request->url_http)->first();
        $new_domain = new Dominios();

        // return response()->json([
        //   $dominio
        // ]);

        // caso nao exista o dominio ele e registrado e feita a importaçao das suas categorias
        if ($dominio == null) {
            
            $new_str = trim($request->url_http,"/");

            $new_domain->dominio = $new_str;
            $new_domain->usuario_dominio = $request->usuario;
            $new_domain->senha_dominio = $request->senha;
            $new_domain->save();

            ImportadorDadosWordPress::carregaTemasWordPress($new_domain->dominio, $new_domain->id);
            echo json_encode(array('status' => 1));
        }




        // $domain = Dominios::where('dominio')
        try {
            $assunto = new RedatorAleatorio();
            $assunto->assunto = $request->descricao_assunto . " - ( Influencers ) ";
            $assunto->idioma =  $request->idioma;
            $assunto->qtd_palavras = $request->quantidade_palavras;
            $assunto->preco_materia = $request->preco_materia;
            $assunto->descricao = $request->descricao_assunto;
            $assunto->usuario_id = 0;
            $assunto->status = 1;
            $assunto->usuario_cadastro_id = 1;
            $assunto->tema_id = 0;
            $assunto->save();
            
            return response()->json([
                'message' => 'Solicitação realizada com sucesso'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Solicitação recusada'
            ]);
        }
    }
}
