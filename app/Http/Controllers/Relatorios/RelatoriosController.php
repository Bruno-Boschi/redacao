<?php

namespace App\Http\Controllers\Relatorios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Relatorios\RelatorioRedatores;
use Illuminate\Validation\Factory;

class RelatoriosController extends Controller
{
    public function __construct(Request $request, Factory $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->middleware('auth');
    }

    public function getRedatores()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosRelatorios($request);
            echo $dados;
            exit();
        }


        $sql = 'SELECT count(usuario_id) as total_materias, 
                	   (SELECT COUNT(*) 
                        FROM redator_aleatorio 
                        WHERE usuario_id = materias.usuario_id
                          AND status = 2) as rejeitado,
                       (SELECT COUNT(*) 
                        FROM redator_aleatorio 
                        WHERE usuario_id = materias.usuario_id
                        AND status = 3) as aceito,
                       users.name,
                        materias.usuario_id as user_id
                FROM materias
                INNER JOIN users ON users.id = materias.usuario_id
                WHERE materias.deleted_at is null
                GROUP BY usuario_id, users.name';
        $records = \DB::select($sql);

        foreach ($records as $record) {

            $relatorio = RelatorioRedatores::where('relatorio_redatores.user_id', '=', $record->user_id)->first();
            if ($relatorio) {
                $relatorio->user_id = $record->user_id;
                $relatorio->aceito = $record->aceito;
                $relatorio->total_materias = $record->total_materias;
                $relatorio->rejeitado = $record->rejeitado;
                $relatorio->save();
            } else {
                $relatorio = new RelatorioRedatores();

                $relatorio->user_id = $record->user_id;
                $relatorio->aceito = $record->aceito;
                $relatorio->total_materias = $record->total_materias;
                $relatorio->rejeitado = $record->rejeitado;
                $relatorio->save();
            }
        }


        return view('/relatorios/redatores');
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
        $totalRecords = RelatorioRedatores::select('count(*) as allcount')->count();
        $totalRecordswithFilter = RelatorioRedatores::select('count(*) as allcount')
            ->leftJoin('users', 'users.id', '=', 'relatorio_redatores.user_id')
            ->select(
                'relatorio_redatores.*',
                'users.name as name',
            )
            ->where('name', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = RelatorioRedatores::orderBy($columnName, $columnSortOrder)
            ->leftJoin('users', 'users.id', '=', 'relatorio_redatores.user_id')
            ->where('users.name', 'like', '%' . $searchValue . '%')
            ->select(
                'relatorio_redatores.*',
                'users.name as name',
                'users.email as email',
                'users.tipo_redator as tipo_redator',
            )
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "name" => $record->name,
                "email" => $record->email,
                "tipo_redator" => $record->tipo_redator,
                "total_materias" => $record->total_materias,
                "rejeitado" => $record->rejeitado,
                "aceito" => $record->aceito,
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
