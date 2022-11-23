<?php

namespace App\Http\Controllers\Relatorios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Factory;

class RelatoriosController extends Controller
{
    public function __construct(Request $request, Factory $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->middleware('auth');
    }

    /**
     * Responds to any (GET,POST, etc) request to /users
     */
    public function getIndex()
    {
        // $request = $this->request->all();
        // if (!empty($request)) {
        //     $dados = $this->rankingRedatores();
        //     \dd($dados);
        //     echo $dados;
        //     exit();
        // }

        $dados = $this->rankingRedatores();
        \dd($dados);

        return view('/relatorios/index', compact(
            'dados',
        ));
    }

    /**
     * Responds to requests to GET /users/show/1
     */
    private function dadosRelatorios($request)
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

    private static function rankingRedatores()
    {
        $sql = 'SELECT count(usuario_id) as total_materias, 
                	   (SELECT COUNT(*) 
                        FROM redator_aleatorio 
                        WHERE usuario_id = materias.usuario_id
                          AND status = 2) as rejetado,
                       (SELECT COUNT(*) 
                        FROM redator_aleatorio 
                        WHERE usuario_id = materias.usuario_id
                          AND status = 3) as aceite,
                       users.name,
                        materias.usuario_id as id
                FROM materias
                INNER JOIN users ON users.id = materias.usuario_id
                WHERE materias.deleted_at is null
                GROUP BY usuario_id, users.name
                LIMIT 50;';
        $records = \DB::select($sql);

        return $records;
    }

    /**
     * Responds to requests to GET /users/admin-profile
     */
    public function getAdminProfile()
    {
        //
    }

    /**
     * Responds to requests to POST /users/profile
     */
    public function postProfile()
    {
        //
    }
}
