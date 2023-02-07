<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materias\RedatorAleatorio;

class SolicitacaoController extends Controller
{

    public function solicitacaoIntegra(Request $request)
    {
        try {
            $assunto = new RedatorAleatorio();
            $assunto->assunto = $request->assunto . " - ( Influencers ) ";
            $assunto->idioma =  $request->idioma;
            $assunto->qtd_palavras = $request->qtd_palavras;
            $assunto->preco_materia = $request->preco_materia;
            $assunto->descricao = $request->descricao_assunto;
            $assunto->usuario_id = 0;
            $assunto->status = 0;
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
