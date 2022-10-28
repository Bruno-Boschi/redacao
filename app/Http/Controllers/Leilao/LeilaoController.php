<?php

namespace App\Http\Controllers\Leilao;

use App\Models\Materias\Materias;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Factory;
use Illuminate\Http\Request;

class LeilaoController extends Controller
{
    //
    public function __construct(Request $request, Factory $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->middleware('auth');
    }

    public function getIndex()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosLeilao($request);
            echo $dados;
            exit();
        }
        return view('leilao/index');
    }

    private function dadosLeilao($request)
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
        $totalRecords = Materias::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Materias::select('count(*) as allcount')
            ->where('assunto', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = Materias::orderBy($columnName, $columnSortOrder)
            ->where('assunto', 'like', '%' . $searchValue . '%')
            ->where('users.tipo_redator', 'PJ')
            ->where('leilao', 1)
            ->select('materias.*', 'users.name', 'temas.descricao as tema', 'users.tipo_redator as user_redator')
            ->leftJoin('temas', 'temas.id', '=', 'materias.tema_id')
            ->leftJoin('users', 'users.id', '=', 'materias.usuario_id')
            ->skip($start)
            ->take($rowperpage)
            ->get();



        $data_arr = array();

        foreach ($records as $record) {
            $caminho = '';
            if (!empty($record->imagem_principal)) {
                $Caracterimagem = substr($record->imagem_principal, 0, 5);
                $caminho = $Caracterimagem == 'https' ? $record->imagem_principal : '/assets/materias/imagem_materias/' . $record->imagem_principal;
            }
            $status = Materias::STATUS_MATERIAS[$record->status];
            $tema = !empty($record->tema) ? $record->tema : 'Não Informado';
            $usuario = !empty($record->name) ? $record->name : 'Admin';
            $data_arr[] = array(
                "imagem_principal" => '<div ><img width="70"  src="' . $caminho . '"></div>',
                "assunto" => $record->assunto,
                "name" => $usuario . ' - ' . $record->user_redator,
                "idioma" => $record->idioma,
                "valor_post" => $record->valor_post,
                "status" => $status,
                "options" => '<div class="m-icon"><a href="/materias/visualizar-materia/' . $record->id . '" title="Visualizar"><i class="me-2 mdi mdi-pencil-box-outline"></i></a></div>'
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
}
