<?php

namespace App\Http\Controllers\Dominios;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Videos\Videos;
use App\Models\Dominios\Dominios;
use App\Helpers\ImportadorDadosWordPress;

class DominiosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Factory $validator)
    {
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
            $dados = $this->dadosDominios($request);
            echo $dados;
            exit();
        }
        return view('dominios/index');
    }

    private function dadosDominios($request)
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
        $totalRecords = Dominios::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Dominios::select('count(*) as allcount')
            ->where('dominio', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = Dominios::orderBy($columnName, $columnSortOrder)
            ->where('dominio', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "dominio" => $record->dominio,
                "usuario_dominio" => $record->usuario_dominio,
                "senha_dominio" => $record->senha_dominio,
                "options" => "<div class='m-icon'><a href='#dialog1' onclick='abrirModal(" . $record->id . ")' title='Cadastrar' name='modal'><i class='me-2 mdi mdi-pencil'></i></a></div>
                              <input type='hidden' id='dominio_" . $record->id . "' value='" . $record->dominio . "'>
                              <input type='hidden' id='usuario_dominio_" . $record->id . "' value='" . $record->usuario_dominio . "'>
                              <input type='hidden' id='senha_dominio_" . $record->id . "' value='" . $record->senha_dominio . "'>
                              <div class='m-icon'><a href='/dominios/excluir/" . $record->id . "' title='Excluir'><i class='me-2 mdi mdi-delete'></i></a></div>
                              <div class='m-icon'><a href='#dialog1' onclick='abrirModalSincronizacao(" . $record->id . ")' title='Baixar Dados' name='modal'><i class='me-2 mdi mdi-arrow-down-bold'></i></a></div>"
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

    public function postSalvarDominio()
    {
        $request = $this->request->all();
        if (empty($request['idDominio'])) {
            $dominio = new Dominios;
            $dominio->dominio = $request['dominio'];
            $dominio->usuario_dominio = $request['dominioUsuario'];
            $dominio->senha_dominio = $request['dominioSenha'];
            $dominio->save();
        } else {
            $dominio = Dominios::find($request['idDominio']);
            $dominio->dominio = $request['dominio'];
            $dominio->usuario_dominio = $request['dominioUsuario'];
            $dominio->senha_dominio = $request['dominioSenha'];
            $dominio->save();
        }
        echo json_encode(array('status' => 1));
        exit;
    }

    public function getExcluir($id)
    {
        $video = Dominios::find($id);
        $video->delete();
        return redirect('dominios')->with('mensagem', 'Domínio excluido com sucesso.');
    }

    public function postImportarTemas()
    {
        $request = $this->request->all();
        $dominio = Dominios::find($request['idDominio']);
        ImportadorDadosWordPress::carregaTemasWordPress($dominio->dominio, $request['idDominio']);
        echo json_encode(array('status' => 1));
        exit;
    }

    public function postImportarMaterias()
    {
        $request = $this->request->all();
        $dominio = Dominios::find($request['idDominio']);
        //DESABILITADO TEMPORARIAMENTE -  PUXA AS MATERIAS JA PUBLICADAS
        // ImportadorDadosWordPress::carregaPostWordPress($dominio->dominio, $request['idDominio']);
        echo json_encode(array('status' => 1));
        exit;
    }
}
