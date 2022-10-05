<?php

namespace App\Http\Controllers\Referencias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materias\ReferenciasMaterias;
use App\Models\Materias\Temas;
use Illuminate\Validation\Factory;

class ReferenciasMateriasController extends Controller
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

    // public function getIndex()
    // {
    //     $referencias = ReferenciasMaterias::leftJoin('temas', 'temas.id', '=', 'referencias_materias.tema_id')
    //         ->leftJoin('materias', 'materias.id', '=', 'referencias_materias.materia_id')
    //         ->select('referencias_materias.*', 'temas.descricao as tema_descricao', 'materias.assunto as materia_assunto')
    //         ->get();

    //     return view('referencias/index', compact('referencias'));
    // }

    public function getIndex()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosReferencias($request);
            echo $dados;
            exit();
        }
        return view('/referencias/index');
    }

    private function dadosReferencias($request)
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
        $totalRecords = ReferenciasMaterias::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ReferenciasMaterias::select('count(*) as allcount')
            ->where('titulo', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = ReferenciasMaterias::orderBy($columnName, $columnSortOrder)
            ->where('titulo', 'like', '%' . $searchValue . '%')
            ->leftJoin('temas', 'temas.id', '=', 'referencias_materias.tema_id')
            ->leftJoin('materias', 'materias.id', '=', 'referencias_materias.materia_id')
            ->select('referencias_materias.*', 'temas.descricao as tema_descricao', 'materias.assunto as materia_assunto')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "titulo" => $record->titulo,
                "tema_descricao" => $record->tema_descricao,
                "link" => $record->link,
                "options" => '<div class="m-icon"><a href="/referencias-materias/create-edit/' . $record->id . '" title="Editar"><i class="me-2 mdi mdi-grease-pencil"></i></a></div>
                              <div class="m-icon"><a href="/referencias-materias/delete/' . $record->id . '" title="Excluir"><i class="me-2 mdi mdi-delete"></i></a></div>
                              '
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
        $temas = Temas::orderBy('descricao', 'ASC')->get();
        if ($id == 0) {

            return view('/referencias/create-edit', compact('temas'));
        } else {
            $referencia = ReferenciasMaterias::find($id);

            return view('referencias/create-edit', compact('temas', 'referencia'));
        }
    }

    public function createEdit(Request $request)
    {
        if (empty($request->id)) {
            $referencia = new ReferenciasMaterias();
            $referencia->titulo = $request->titulo;
            $referencia->tema_id = $request->tema_id;
            $referencia->materia_id = 0;
            $referencia->link = $request->link;
            $referencia->save();
            $mensagem = 'Tema cadastrado com sucesso.';
        } else {
            $referencia = ReferenciasMaterias::find($request->id);
            $referencia->titulo = $request->titulo;
            $referencia->update();
            $mensagem = 'Tema editado com sucesso.';
        }

        return redirect('referencias-materias')->with('mensagem', $mensagem);
    }

    public function delete($id)
    {
        $referencia = ReferenciasMaterias::find($id);
        $referencia->delete();
        return redirect('/referencias-materias')->with('mensagem', 'Referencia excluida com sucesso.');
    }
}
