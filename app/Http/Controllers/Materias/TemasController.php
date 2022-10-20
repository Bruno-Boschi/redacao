<?php

namespace App\Http\Controllers\Materias;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\Models\Materias\Temas;
use App\User;
use App\Models\Materias\RedatorAleatorio;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DadosRedatores;
use App\Models\Configuracoes\Configuracoes;
use App\Models\Materias\ReferenciasTemas;
use App\Models\Materias\Materias;
use App\Models\Materias\ReferenciasMaterias;

class TemasController extends Controller
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
            $dados = $this->dadosTemas($request);
            echo $dados;
            exit();
        }
        return view('temas/index');
    }

    private function dadosTemas($request)
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
        $totalRecords = Temas::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Temas::select('count(*) as allcount')
            ->where('descricao', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = Temas::orderBy($columnName, $columnSortOrder)
            ->where('descricao', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "descricao" => $record->descricao,
                "options" => '<div class="m-icon"><a href="/temas/create-edit/' . $record->id . '" title="Excluir"><i class="me-2 mdi mdi-pencil"></i></a></div>
                              <div class="m-icon"><a href="/temas/excluir/' . $record->id . '" title="Excluir"><i class="me-2 mdi mdi-delete"></i></a></div>'
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
        $tema = Temas::find($id);
        return view('temas/create-edit', compact('tema'));
    }

    public function postSalvarTema()
    {
        $request = $this->request->all();
        if (empty($request['id'])) {
            $temas = new Temas;
            $temas->descricao = $request['assunto'];
            $temas->save();
            $mensagem = 'Tema cadastrado com sucesso.';
        } else {
            $temas = Temas::find($request['id']);
            $temas->descricao = $request['assunto'];
            $temas->save();

            ReferenciasTemas::where('tema_id', $request['id'])->delete();
            $mensagem = 'Tema editado com sucesso.';
        }

        return redirect('temas')->with('mensagem', $mensagem);
    }

    public function postDeletarReferencia()
    {
        $request = $this->request->all();
        $faq = ReferenciasTemas::find($request['idReferencia']);
        $faq->delete();
        echo json_encode(array('status' => 1));
        exit;
    }

    public function getExcluir($id)
    {
        $tema = Temas::find($id);
        $tema->delete();
        return redirect('temas')->with('mensagem', 'Tema excluido com sucesso.');
    }

    public function getRedatorAleatorio()
    {
        $request = $this->request->all();
        // $temas = Temas::orderBy('descricao', 'ASC')->get();
        if (!empty($request)) {
            $dados = $this->dadosRedatorAleatorio($request);
            echo $dados;
            exit();
        }
        return view('temas/redator-aleatorio');
    }

    public function getCreateEditRedator($id = 0)
    {
        // $temas = Temas::orderBy('descricao', 'ASC')->get();


        $temaReferencias = ReferenciasTemas::where('tema_id', '=', $id)->get();

        $redatorAleatorio = RedatorAleatorio::find($id);

        // $referencias = ReferenciasMaterias::orderBy('titulo', 'ASC')->get();
        return view('temas/create-edit-redator', compact('temaReferencias', 'redatorAleatorio'));
    }

    private function dadosRedatorAleatorio($request)
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
        $totalRecords = RedatorAleatorio::select('count(*) as allcount')->count();
        $totalRecordswithFilter = RedatorAleatorio::select('count(*) as allcount')
            ->where('assunto', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = RedatorAleatorio::orderBy($columnName, $columnSortOrder)
            ->where('redator_aleatorio.assunto', 'like', '%' . $searchValue . '%')
            ->select('redator_aleatorio.*', 'users.name', 'temas.descricao')
            ->leftJoin('temas', 'temas.id', '=', 'redator_aleatorio.tema_id')
            ->leftJoin('users', 'users.id', '=', 'redator_aleatorio.usuario_id')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $status = RedatorAleatorio::STATUS_ASSUNTO[$record->status];
            $data_arr[] = array(
                "assunto" => $record->assunto,
                "redator" => $record->name,
                "descricao" => $record->descricao,
                "idioma" => $record->idioma,
                "status" => $status,
                "options" => '<div class="m-icon"><a href="/temas/excluir-redator/' . $record->id . '" title="Excluir"><i class="me-2 mdi mdi-delete"></i></a></div>'
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

    public function getRedator()
    {
        $request = $this->request->all();

        $json[] = [
            'id' => 0,
            'text' => 'Aleatório'
        ];
        $records = User::orderBy('name', 'desc')
            ->where('name', 'like', '%' . $request['searchTerm'] . '%')
            ->where('tipo_usuario', '=', 'R')
            ->skip(0)
            ->take(10)
            ->get();
        foreach ($records as $record) {
            $json[] = [
                'id' => $record->id,
                'text' => $record->name
            ];
        }
        return json_encode($json);
    }

    public function getTemasCadastrado(Request $request)
    {

        $json[] = [
            'id' => 0,
            'text' => 'Geral'
        ];
        $records = Temas::orderBy('descricao', 'desc')
            ->where('descricao', 'like', '%' . $request['searchTerm'] . '%')
            ->skip(0)
            ->take(10)
            ->get();

        foreach ($records as $record) {
            $json[] = [
                'id' => $record->id,
                'text' => $record->descricao
            ];
        }
        return json_encode($json);
    }

    public function getMateriasCadastrada(Request $request)
    {

        $json[] = [
            'id' => 0,
            'text' => 'Aleatório'
        ];
        $records = Materias::orderBy('assunto', 'desc')
            ->where('assunto', 'like', '%' . $request['searchTerm'] . '%')
            ->skip(0)
            ->take(10)
            ->get();

        foreach ($records as $record) {
            $json[] = [
                'id' => $record->id,
                'text' => $record->assunto
            ];
        }
        return json_encode($json);
    }



    public function postSalvarRedatorAleatorio()
    {
        $request = $this->request->all();
        $redatorSelecionado = (!isset($request['redator'])) ? $this->proximoUsuarioCadastrarTema(0) :
            $request['redator'];
        if (isset($request['preco_materia'])) {
            $numero = str_replace('.', '', $request['preco_materia']);
            $numero = str_replace(',', '.', $numero);
        } else {
            $numero = 0;
        }

        $assunto = new RedatorAleatorio;
        $assunto->assunto = $request['assunto'];
        $assunto->idioma = $request['idioma'];
        $assunto->qtd_palavras = $request['qtd_palavras'];
        $assunto->preco_materia = $numero;
        $assunto->descricao = $request['descricao_assunto'];
        $assunto->usuario_id = $redatorSelecionado;
        $assunto->status = 0;
        $assunto->usuario_cadastro_id = Auth::user()->id;
        $assunto->tema_id = $request['tema'];
        $assunto->save();


        if (isset($request['titulo'])) {
            for ($i = 0; $i < count($request['titulo']); $i++) {
                $referencia = new ReferenciasTemas;
                $referencia->descricao = $request['descricao_referencia'][$i];
                $referencia->titulo = $request['titulo'][$i];
                $referencia->tema_id = $assunto->id;
                // $referencia->materia_id = ($request['materia'][$i] == 'null') ? 0 : $request['materia'][$i];
                $referencia->materia_id = 0;
                $referencia->save();
            }
        }

        return redirect('temas/redator-aleatorio')->with('mensagem', 'Redator Aleatório cadastrado com sucesso.');
    }

    public function getExcluirRedator($id)
    {
        $tema = RedatorAleatorio::find($id);
        $tema->delete();
        return redirect('temas/redator-aleatorio')->with('mensagem', 'Redator Aleatório excluido com sucesso.');
    }

    public function getAssuntoAleatorio($id)
    {
        $date = new \DateTime();
        $assunto = RedatorAleatorio::find($id);
        if ($assunto->status == 0) {
            $assunto->status = 1;
            $assunto->data_leitura = $date->format('Y-m-d');
            $assunto->save();
        }

        $totalMateriasRejeitada = DadosRedatores::totalMateriaisRejeitasDiaria($assunto->usuario_id);
        $configuracoes = Configuracoes::find(1);

        $habilitaBotaoRejeitar = ($totalMateriasRejeitada == $configuracoes->total_rejeitos_materia) ? false : true;
        $limiteRejeicoes = (int)$configuracoes->total_rejeitos_materia;

        $assunto = RedatorAleatorio::where('redator_aleatorio.id', '=', $id)
            ->select('redator_aleatorio.*', 'users.name', 'temas.descricao as tema')
            ->leftJoin('temas', 'temas.id', '=', 'redator_aleatorio.tema_id')
            ->leftJoin('users', 'users.id', '=', 'redator_aleatorio.usuario_id')
            ->get();

        $referencias = ReferenciasTemas::where('referencias_temas.tema_id', '=', $id)
            ->select('referencias_temas.*', 'materias.link_wordpress')
            ->leftJoin('materias', 'materias.id', '=', 'referencias_temas.materia_id')
            ->get();

        return view('temas/assunto-aleatorio', compact('assunto', 'habilitaBotaoRejeitar', 'limiteRejeicoes', 'totalMateriasRejeitada', 'referencias'));
    }

    public function postAtualizarAssuntoRedator()
    {
        $request = $this->request->all();
        $date = new \DateTime();
        $idAssunto = $request['idAssunto'];
        $assunto = RedatorAleatorio::find($idAssunto);
        $idMateria = $idAssunto;
        $totalMateriasRejeitada = DadosRedatores::totalMateriaisRejeitasDiaria($assunto->usuario_id);
        $configuracoes = Configuracoes::find(1);

        if ((($totalMateriasRejeitada + 1) > $configuracoes->total_rejeitos_materia) && ((int)$configuracoes->total_rejeitos_materia > 0)) {
            echo json_encode(array('status' => 2, 'totalRejeitada' => $totalMateriasRejeitada));
        } else {
            // if ((int)$request['status'] == 2) {
            //     $proximoRedator = $this->proximoUsuarioCadastrarTema($assunto->usuario_id);

            //     $novoRedator = new RedatorAleatorio;
            //     $novoRedator->assunto = $assunto->assunto;
            //     $novoRedator->descricao = $assunto->descricao;
            //     $novoRedator->usuario_id = $proximoRedator;
            //     $novoRedator->idioma = $assunto->idioma;
            //     $novoRedator->status = 0;
            //     $novoRedator->usuario_cadastro_id = $assunto->usuario_cadastro_id;
            //     $novoRedator->tema_id = $assunto->tema_id;
            //     $novoRedator->save();
            // }


            $assunto->status = $request['status'];
            $assunto->data_leitura = $date->format('Y-m-d');
            if ($assunto->status = 3) {
                $assunto->usuario_id = Auth::user()->id;
            }
            $assunto->save();



            echo json_encode(array(
                'status' => 1,
                'id_tema' => $idMateria,
            ));
        }
        exit;
    }

    public function postTemasAleatorioUsuario()
    {
        $assunto = RedatorAleatorio::orderBy('redator_aleatorio.created_at', 'DESC')
            ->where('redator_aleatorio.usuario_id', '=', Auth::user()->id)
            ->select('redator_aleatorio.*', 'users.name', 'temas.descricao as tema')
            ->leftJoin('temas', 'temas.id', '=', 'redator_aleatorio.tema_id')
            ->leftJoin('users', 'users.id', '=', 'redator_aleatorio.usuario_id')
            ->take(10)
            ->get();


        return;

        echo json_encode(array('status' => 1, 'temas_aleatorio' => $assunto));
        exit;
    }

    private function proximoUsuarioCadastrarTema($usuarioAtual)
    {
        $ultimoUsuarioRedator = RedatorAleatorio::orderBy('id', 'desc')->first();
        if (empty($ultimoUsuarioRedator)) {
            $usuarioAtual = 0;
            $ultimoUsuarioRedator = 0;
        } else {
            $ultimoUsuarioRedator = $ultimoUsuarioRedator->usuario_id;
        }

        if ($usuarioAtual == 0) {
            $usuario = User::where('id', '>', $ultimoUsuarioRedator)
                ->where('ativo', '=', '1')
                ->where('tipo_usuario', '=', 'R')
                ->orderBy('id', 'asc')
                ->first();
            if (empty($usuario)) {
                $usuario = User::where('ativo', '=', '1')
                    ->where('tipo_usuario', '=', 'R')
                    ->orderBy('id', 'asc')
                    ->first();
            }
        } else {
            $usuario = User::where('id', '>', $usuarioAtual)
                ->where('ativo', '=', '1')
                ->where('tipo_usuario', '=', 'R')
                ->orderBy('id', 'asc')
                ->first();
        }


        if ($ultimoUsuarioRedator == $usuario->id) {
            $usuario = User::where('ativo', '=', '1')
                ->where('tipo_usuario', '=', 'R')
                ->orderBy('id', 'asc')
                ->first();
        }

        return $usuario->id;
    }
}
