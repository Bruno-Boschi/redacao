<?php
namespace App\Http\Controllers\Financeiros;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\Models\Configuracoes\Configuracoes;
use App\Helpers\DadosRedatores;
use Illuminate\Support\Facades\Auth;
use App\Models\Financeiros\SolicitacoesSaques;
use App\Helpers\SelecionarUsuario;
use App\User;
use App\Helpers\CentralNotificacao;
use App\Models\CentralNotificacoes\CentralNotificacoes;
use App\Helpers\FormataData;
use Carbon\Carbon;
use App\Models\Dominios\Dominios;
use Illuminate\Support\Facades\Mail;

class FinanceirosController extends Controller
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
        $valorReceber = DadosRedatores::valorTotalReceber(Auth::user()->id);
        $valorTotalSolicitado = DadosRedatores::valorTotalSolicitados(Auth::user()->id);
        $valorTotalReceber = $valorReceber - $valorTotalSolicitado;
        return view('financeiros/index', compact('configuracoes', 'valorTotalReceber'));
    }

    public function getListaSolicitacoesPagamento()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosPagamentosPendentes($request);
            echo $dados;
            exit();
        }
        return view('financeiros/lista-solicitacoes-pagamento');
    }
    
    private function dadosPagamentosPendentes($request, $listagem = false)
    {
        ## Read value
        $draw = $request['draw'];
        $start = $request['start'];
        $rowperpage = $request['length']; // Rows display per page
        
        $columnIndex_arr = $request['order'];
        $columnName_arr = $request['columns'];
        $order_arr = $request['order'];
        $search_arr = $request['search'];
        
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        
        if ($listagem) {
            // Total records
            $totalRecords = SolicitacoesSaques::select('count(*) as allcount')
                ->count();
            $totalRecordswithFilter = SolicitacoesSaques::select('count(*) as allcount')
                ->where('users.name', 'like', '%' .$searchValue . '%')
                ->join('users', 'users.id', '=', 'solicitacoes_saques.usuario_id')
                ->count();
            
            // Fetch records
            $records = SolicitacoesSaques::orderBy($columnName,$columnSortOrder)
                ->where('users.name', 'like', '%' .$searchValue . '%')
                ->select('users.*', 'solicitacoes_saques.valor_saque', 'solicitacoes_saques.id as id_solicitacao')
                ->join('users', 'users.id', '=', 'solicitacoes_saques.usuario_id')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            // Total records
            $totalRecords = SolicitacoesSaques::select('count(*) as allcount')
                ->where('solicitacoes_saques.status', '=', SolicitacoesSaques::CODIGO_PAGAMENTO_PENDENTE)
                ->count();
            $totalRecordswithFilter = SolicitacoesSaques::select('count(*) as allcount')
                ->where('users.name', 'like', '%' .$searchValue . '%')
                ->where('solicitacoes_saques.status', '=', SolicitacoesSaques::CODIGO_PAGAMENTO_PENDENTE)
                ->join('users', 'users.id', '=', 'solicitacoes_saques.usuario_id')
                ->count();
            
            // Fetch records
            $records = SolicitacoesSaques::orderBy($columnName,$columnSortOrder)
                ->where('users.name', 'like', '%' .$searchValue . '%')
                ->where('solicitacoes_saques.status', '=', SolicitacoesSaques::CODIGO_PAGAMENTO_PENDENTE)
                ->select('users.*', 'solicitacoes_saques.valor_saque', 'solicitacoes_saques.id as id_solicitacao')
                ->join('users', 'users.id', '=', 'solicitacoes_saques.usuario_id')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }
        
        $data_arr = array();
        
        foreach($records as $record){
            if ($listagem) {
                $data_arr[] = array(
                    "name" => $record->name,
                    "valor_saque" => number_format($record->valor_saque,2,",","."),
                    "created_at" => FormataData::dataHoraDbParaBr($record->created_at),
                    "data_pagamento" => FormataData::dataDbParaBr($record->data_pagamento)
                );
            } else {
                $data_arr[] = array(
                    "name" => $record->name,
                    "valor_saque" => number_format($record->valor_saque,2,",","."),
                    "created_at" => FormataData::dataHoraDbParaBr($record->created_at),
                    "options" => '<div class="m-icon"><a href="#dialog1" onclick="abrirModal('.$record->id_solicitacao.')" title="Visualizar Dados" name="modal"><i class="me-2 mdi mdi-cash-multiple"></i></a></div>
                              <input type="hidden" id="solicitacao_id_'.$record->id_solicitacao.'" value="'.number_format($record->valor_saque,2,",",".").'">
                              <input type="hidden" id="nome_solicitante_'.$record->id_solicitacao.'" value="'.$record->name.'">
                              <input type="hidden" id="chave_pix_'.$record->id_solicitacao.'" value="'.$record->chave_pix.'">'
                );
            }
        }
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        
        return json_encode($response);
    }
    
    public function getPagamentos()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosPagamentosPendentes($request, true);
            echo $dados;
            exit();
        }
        return view('financeiros/pagamentos');
    }
    
    public function getSolicitacoesPagamento()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosPagamentos($request);
            echo $dados;
            exit();
        }
        return view('financeiros/solicitacoes-pagamento');
    }
    
    private function dadosPagamentos($request)
    {
        ## Read value
        $draw = $request['draw'];
        $start = $request['start'];
        $rowperpage = $request['length']; // Rows display per page
        
        $columnIndex_arr = $request['order'];
        $columnName_arr = $request['columns'];
        $order_arr = $request['order'];
        $search_arr = $request['search'];
        
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        
        // Total records
        $totalRecords = SolicitacoesSaques::select('count(*) as allcount')
            ->where('solicitacoes_saques.usuario_id', '=', Auth::user()->id)
            ->count();
        $totalRecordswithFilter = SolicitacoesSaques::select('count(*) as allcount')
            ->where('users.name', 'like', '%' .$searchValue . '%')
            ->where('solicitacoes_saques.usuario_id', '=', Auth::user()->id)
            ->join('users', 'users.id', '=', 'solicitacoes_saques.usuario_id')
            ->count();
        
        // Fetch records
        $records = SolicitacoesSaques::orderBy($columnName,$columnSortOrder)
            ->where('users.name', 'like', '%' .$searchValue . '%')
            ->where('solicitacoes_saques.usuario_id', '=', Auth::user()->id)
            ->select('users.*', 'solicitacoes_saques.valor_saque', 
                    'solicitacoes_saques.id as id_solicitacao', 
                    'solicitacoes_saques.status as pagamento',
                    'solicitacoes_saques.data_pagamento',
                    'solicitacoes_saques.comprovante')
            ->join('users', 'users.id', '=', 'solicitacoes_saques.usuario_id')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $data_arr[] = array(
                "name" => $record->name,
                "valor_saque" => number_format($record->valor_saque,2,",","."),
                "created_at" => FormataData::dataHoraDbParaBr($record->created_at),
                "data_pagamento" => FormataData::dataDbParaBr($record->data_pagamento),
                "status" => SolicitacoesSaques::STATUS_SOLICITACAO[$record->pagamento],
                "options" => '<div class="m-icon"><a href="/assets/financeiros/documentos/'.$record->id_solicitacao.'/'.$record->comprovante.'" target="_blank" title="Visualizar"><i class="me-2 mdi mdi-arrow-down-bold"></i></a></div>'
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        
        return json_encode($response);
    }
    
    public function getSalvar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $configuracao = Configuracoes::find(1);
            $valorSaque = str_replace('.', '', $request['valor_saque']);
            $valorSaque = str_replace(',', '.', $valorSaque);
            $valorSaqueInteiro = str_replace('.', '', $valorSaque);
            $valorMinimoSaque = str_replace('.', '', $configuracao->valor_minimo);
            $valorTotalSaldo = DadosRedatores::valorTotalReceber(Auth::user()->id);
            $valorTotalReceber = str_replace('.', '', $valorTotalSaldo);
            
            if ($valorSaqueInteiro < $valorMinimoSaque){
                return redirect('financeiros')->with('erro', 'Valor Mínimo para solicitação do saque é de '.number_format($configuracao->valor_minimo,2,",","."));
            }
            
            if ($valorSaqueInteiro > $valorTotalReceber){
                return redirect('financeiros')->with('erro', 'Valor da solicitação da saque é maior que o saldo atual '.number_format($valorTotalSaldo,2,",","."));
            }
            
            $mensagem = 'Redator '.Auth::user()->name.' solicitou pagamento.';
            $usuarioModulo = SelecionarUsuario::proximoUsuarioCadastrarMensagemSuporte(0, User::CODIGO_USUARIO_FINANCEIRO);
            CentralNotificacao::salvarNotificaoUsuario($usuarioModulo, $mensagem, CentralNotificacoes::MODULO_FINANCEIRO);
            
            $solicitacaoSaque = new SolicitacoesSaques;
            $solicitacaoSaque->valor_saque = $valorSaque;
            $solicitacaoSaque->usuario_id = Auth::user()->id;
            $solicitacaoSaque->status = SolicitacoesSaques::CODIGO_PAGAMENTO_PENDENTE;
            $solicitacaoSaque->save();

                $financeiros = User::where('departamento_id', 2)->where('ativo','!=', 0)->get();
                $user = User::where('id',$solicitacaoSaque->usuario_id)->first();
                foreach ($financeiros as $financeiro) {
                 Mail::send( new \App\Mail\solicitarPag($financeiro, $user));
                }

            return redirect('financeiros')->with('mensagem', 'Pagamento solicitado com sucesso.');
        }
        
        return view('configuracoes');
    }
    
    public function anyFaturamentoDominio()
    {
        $request = $this->request->all();
        $dominios = Dominios::all();
        $dados = [];
        $idDominio = '';
        if (!empty($request)) {
            $dataInicial = FormataData::dataBrParaDb($request['data_inicial']);
            $dataFinal = FormataData::dataBrParaDb($request['data_final']);
            $sql = 'SELECT SUM(impressoes) as impressoes, 
                           SUM(cliques) as cliques, 
                           SUM(valor_impressao) as valor_impressao, 
                           data_busca, 
                           faturamento_dominio.id_wordpress,
                           dominios.dominio
                    FROM faturamento_dominio 
                    INNER JOIN dominios ON dominios.id = faturamento_dominio.dominio_id
                    INNER JOIN materias ON materias.id_wordpress = faturamento_dominio.id_wordpress
                                       AND materias.id_dominio = faturamento_dominio.dominio_id
                    WHERE dominio_id = '.$request['dominio_id'].'
                      AND faturamento_dominio.id_wordpress <> 0
                      AND data_busca BETWEEN "'.$dataInicial.'" AND "'.$dataFinal.'"
                    GROUP BY data_busca, faturamento_dominio.id_wordpress, dominios.dominio
                    ORDER BY data_busca ASC;';

            $dados = \DB::select($sql);
            $idDominio = $request['dominio_id'];
        }
        return view('financeiros/faturamento-dominio', compact('dados', 'dominios', 'idDominio'));
    }
    
    public function postSalvarPagamento()
    {
        $request = $this->request->all();
        
        $solicitacaoSaque = SolicitacoesSaques::find($request['idSolicitacao']);
        $usuario = $solicitacaoSaque->usuario_id;
        $solicitacaoSaque->status = $request['idStatus'];
        $solicitacaoSaque->comprovante = $request['comprovante'];
        if ($request['idStatus'] == SolicitacoesSaques::CODIGO_PAGAMENTO_EFETUADO) {
            $date = new \DateTime();
            $solicitacaoSaque->data_pagamento = $date->format('Y-m-d');
        }
        $solicitacaoSaque->save();
        
        $mensagem = ($request['idStatus'] == SolicitacoesSaques::CODIGO_PAGAMENTO_EFETUADO) ?
            'Pagamento efetuado.' : 
            $request['descricao'];
        
        CentralNotificacao::salvarNotificaoUsuario($usuario, $mensagem, CentralNotificacoes::MODULO_FINANCEIRO);

         $user = User::find($usuario);
        
        Mail::send(new \App\Mail\pagFeito($user));
        echo json_encode(array('status' => 1));
        exit;
    }
    
    public function postUpload($id=null)
    {
        if($_FILES){
            $files = \Request::file('file');
            
            $file = $this->uploadFile2($files, $_FILES['file']['name'], 'financeiros', '/documentos/'.$id);
            
            if($file){
                $json = array(
                    'res'=>1,
                    'msg'=>$file,
                    'dir'=>$file
                );
            } else {
                $json = array(
                    'res'=>2,
                    'msg'=>'erro ao enviar'
                );
            }
            echo json_encode($json);
            exit();
        }
    }
    
    public function uploadFile2($file, $Nome, $raiz, $pasta)
    {
        $urlAmigavel = $this->urlAmigavel($Nome . "-" . md5(Carbon::now() . $file->getClientOriginalName()));
        
        if ($file->isValid()) {
            if ($file->getClientOriginalExtension() == "png" || 
                $file->getClientOriginalExtension() == "jpg" || 
                $file->getClientOriginalExtension() == "ico" || 
                $file->getClientOriginalExtension() == "jpeg" || 
                $file->getClientOriginalExtension() == "pdf" ||
                $file->getClientOriginalExtension() == "gif") {
                $nomeArquivo = $urlAmigavel;
                $extensao = $file->getClientOriginalExtension();

                mkdir('assets/' . $raiz . $pasta, 0777);
                $file->move('assets/' . $raiz . $pasta, $nomeArquivo . ".$extensao");
                return $nomeArquivo . ".$extensao";
            } else {
                $validator[] = "Permitido apenas imagem (png ou jpeg)";
                return redirect("/{$this->diretorioPrincipal}/{$this->nameView}/create")->withErrors($validator)->withInput();
            }
        }
    }
    
    public function urlAmigavel($Titulo) {
        $url_amigavel = str_slug($Titulo, "-");
        return $url_amigavel;
    }
    
}