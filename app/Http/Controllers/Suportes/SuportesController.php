<?php
namespace App\Http\Controllers\Suportes;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\Models\Suportes\Chamados;
use Illuminate\Support\Facades\Auth;
use App\Helpers\FormataData;
use App\User;
use App\Models\Suportes\ChamadoDetalhes;
use App\Helpers\SelecionarUsuario;
use App\Models\CentralNotificacoes\CentralNotificacoes;
use App\Helpers\CentralNotificacao;

class SuportesController extends Controller
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
        $request = $this->request->all();
        if (!empty($request)) {
            if(Auth::user()->tipo_usuario == 'A') {
                $dados = $this->dadosMeusChamadosSuporte($request);
            } else {
                $dados = $this->dadosMeusChamadosRedator($request);
            }
            echo $dados;
            exit();
        }
        return view('suportes/index');
    }
    
    private function dadosMeusChamadosSuporte($request)
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
        $totalRecords = Chamados::select('count(*) as allcount')
            ->where('usuario_suporte_id', '=', Auth::user()->id)
            ->count();
        $totalRecordswithFilter = Chamados::select('count(*) as allcount')
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->where('usuario_suporte_id', '=', Auth::user()->id)
            ->count();
        
        // Fetch records
        $records = Chamados::orderBy($columnName,$columnSortOrder)
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->where('usuario_suporte_id', '=', Auth::user()->id)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $departamento = User::DEPARTAMENTO_USUARIO[$record->departamento_id];
            $status = Chamados::STATUS_CHAMADO[$record->status];
            $data_arr[] = array(
                "titulo" => $record->titulo,
                "created_at" => FormataData::dataHoraDbParaBr($record->created_at),
                "departamento_id" => $departamento,
                "status" => $status,
                "options" => '<div class="m-icon"><a href="/suportes/visualizar-chamado/'.$record->id.'" title="Editar"><i class="me-2 mdi mdi-eye-outline"></i></a></div>'
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
    
    private function dadosMeusChamadosRedator($request)
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
        $totalRecords = Chamados::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Chamados::select('count(*) as allcount')
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->where('usuario_id', '=', Auth::user()->id)
            ->count();
        
        // Fetch records
        $records = Chamados::orderBy($columnName,$columnSortOrder)
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->where('usuario_id', '=', Auth::user()->id)
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $departamento = User::DEPARTAMENTO_USUARIO[$record->departamento_id];
            $status = Chamados::STATUS_CHAMADO[$record->status];
            $data_arr[] = array(
                "titulo" => $record->titulo,
                "created_at" => FormataData::dataHoraDbParaBr($record->created_at),
                "departamento_id" => $departamento,
                "status" => $status,
                "options" => '<div class="m-icon"><a href="/suportes/visualizar-chamado/'.$record->id.'" title="Editar"><i class="me-2 mdi mdi-eye-outline"></i></a></div>'
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
    
    public function getCreateEdit()
    {
        $departamentos = User::DEPARTAMENTO_USUARIO;
        return view('suportes/create-edit', compact('departamentos'));
    }
    
    public function postSalvar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $usuarioModulo = SelecionarUsuario::proximoUsuarioCadastrarMensagemSuporte(0, $request['departamento']);
            $chamado = new Chamados;
            $chamado->titulo = $request['titulo'];
            $chamado->departamento_id = $request['departamento'];
            $chamado->status = Chamados::CODIGO_CHAMADO_ABERTO;
            $chamado->usuario_id = Auth::user()->id;
            $chamado->usuario_suporte_id = $usuarioModulo;
            $chamado->save();
            
            $detalhamento = new ChamadoDetalhes;
            $detalhamento->mensagem = $request['descricao'];
            $detalhamento->chamado_id = $chamado->id;
            $detalhamento->tipo_mensagem = 'C';
            $detalhamento->save();
            
            $mensagem = 'Foi aberto o chamado Nº '.$chamado->id;
            CentralNotificacao::salvarNotificaoUsuario($usuarioModulo, $mensagem, CentralNotificacoes::MODULO_SUPORTE);            
            
            $mensagem = 'Em breve entraremos com contato referente ao seu chamado.';
            return redirect('suportes')->with('mensagem', $mensagem);
        }
        
        return view('suportes');
    }
    
    public function postEditar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            if(Auth::user()->tipo_usuario == 'A') {
                $chamado = Chamados::find($request['id']);
                $chamado->status = $request['status'];
                $chamado->save();
            }                
            
            $detalhamento = new ChamadoDetalhes;
            $detalhamento->mensagem = $request['descricao'];
            $detalhamento->chamado_id = $request['id'];
            $detalhamento->tipo_mensagem = $request['tipo_mensagem'];
            $detalhamento->save();
            
            $mensagem = 'Chamado Nº '.$request['id'].' possui uma nova interação.';
            if(Auth::user()->tipo_usuario == 'A') {
                CentralNotificacao::salvarNotificaoUsuario($chamado->usuario_id, $mensagem, CentralNotificacoes::MODULO_SUPORTE);
            } else {
                CentralNotificacao::salvarNotificaoUsuario($request['usuario_id'], $mensagem, CentralNotificacoes::MODULO_SUPORTE);
            }
            
            $mensagem = 'Em breve entraremos com contato referente ao seu chamado.';
            return redirect('suportes')->with('mensagem', $mensagem);
        }
        
        return view('suportes');
    }
    
    public function getVisualizarChamado($id)
    {
        $chamado = Chamados::where('chamados.id', '=', $id)
            ->select('chamados.*', 'users.name')
            ->join('users', 'users.id', '=', 'chamados.usuario_id')
            ->get();
        $detalhamentos = ChamadoDetalhes::orderBy('chamado_detalhes.id','asc')
            ->where('chamado_id', '=', $id)
            ->select('chamado_detalhes.*')
            ->get();
        $atendente = User::find($chamado[0]['usuario_suporte_id']);
            
        $statusChamado = Chamados::STATUS_CHAMADO;
        
        return view('suportes/visualizar-chamado', compact('chamado', 'detalhamentos', 'statusChamado', 'atendente'));
    }
    
}