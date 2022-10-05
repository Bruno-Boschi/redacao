<?php
namespace App\Http\Controllers\Configuracoes;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\Models\Configuracoes\Configuracoes;

class ConfiguracoesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Factory $validator) {
        $this->request = $request;
        $this->validator = $validator;
        $this->middleware('auth');
    }
    
    public function show($id)
    {
        //
    }
    
    public function getIndex()
    {
        $configuracoes = Configuracoes::find(1);
        return view('configuracoes/index', compact('configuracoes'));
    }

    public function getSalvar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $valorMinimo = str_replace('.', '', $request['valor_minimo']);
            $valorMinimo = str_replace(',', '.', $valorMinimo);
            
            $valorMateria = str_replace('.', '', $request['valor_materia']);
            $valorMateria = str_replace(',', '.', $valorMateria);

            $configuracao = Configuracoes::find($request['id']);
            $configuracao->valor_minimo = $valorMinimo;
            $configuracao->valor_materia = $valorMateria;
            $configuracao->regras_pagamento = $request['descricao'];
            $configuracao->usuario_sms = $request['usuario_sms'];
            $configuracao->senha_sms = $request['senha_sms'];
            $configuracao->total_rejeitos_materia = $request['total_rejeitos_materia'];
            $configuracao->save();

            return redirect('configuracoes')->with('mensagem', 'Configuração alterada com sucesso.');
        }
        
        return view('configuracoes');
    }
}