<?php
namespace App\Http\Controllers\Avisos;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\Models\Avisos\Avisos;
use App\Helpers\CentralNotificacao;

class AvisosController extends Controller
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
            $dados = $this->dadosFaqs($request);
            echo $dados;
            exit();
        }
        return view('avisos/index');
    }
    
    private function dadosFaqs($request)
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
        $totalRecords = Avisos::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Avisos::select('count(*) as allcount')
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->count();
        
        // Fetch records
        $records = Avisos::orderBy($columnName,$columnSortOrder)
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $data_arr[] = array(
                "titulo" => $record->titulo,
                "options" => '<div class="m-icon"><a href="/avisos/create-edit/'.$record->id.'" title="Editar"><i class="me-2 mdi mdi-grease-pencil"></i></a></div>
                              <div class="m-icon"><a href="/avisos/excluir/'.$record->id.'" title="Excluir"><i class="me-2 mdi mdi-delete"></i></a></div>'
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
    
    public function getCreateEdit($id = 0)
    {
        $aviso = Avisos::find($id);
        return view('avisos/create-edit', compact('aviso'));
    }
    
    public function getSalvar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            if (isset($request['id'])) {
                $aviso = Avisos::find($request['id']);
                $aviso->titulo = $request['titulo'];
                $aviso->descricao = $request['descricao'];
                $aviso->save();
                $mensagem = 'Aviso editado com sucesso.';
            } else {
                $aviso = new Avisos;
                $aviso->titulo = $request['titulo'];
                $aviso->descricao = $request['descricao'];
                $aviso->save();
                CentralNotificacao::enviarNotificacaoMassaRedatores($request['titulo'], $aviso->id);
                $mensagem = 'Aviso adicionado com sucesso.';
            }
            return redirect('avisos')->with('mensagem', $mensagem);
        }
        
        return view('avisos');
    }
    
    public function getExcluir($id)
    {
        $aviso = Avisos::find($id);
        $aviso->delete();
        return redirect('avisos')->with('mensagem', 'Aviso excluido com sucesso.');
    }
    
    public function getPesquisar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosPesquisar($request);
            echo $dados;
            exit();
        }
        return view('avisos/pesquisar');
    }
    
    private function dadosPesquisar($request)
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
        $totalRecords = Avisos::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Avisos::select('count(*) as allcount')
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->count();
        
        // Fetch records
        $records = Avisos::orderBy($columnName,$columnSortOrder)
            ->where('titulo', 'like', '%' .$searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        $data_arr = array();
        
        foreach($records as $record){
            $data_arr[] = array(
                "titulo" => $record->titulo,
                "options" => '<div class="m-icon"><a href="/avisos/visualizar/'.$record->id.'" target="_blank" title="Visualizar"><i class="me-2 mdi mdi-eye-outline"></i></a></div>'
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

    public function getVisualizar($id)
    {
        $aviso = Avisos::find($id);
        return view('avisos/visualizar', compact('aviso'));
    }
}