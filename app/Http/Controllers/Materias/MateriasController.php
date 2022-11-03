<?php

namespace App\Http\Controllers\Materias;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\Models\Materias\Materias;
use App\Models\Materias\Temas;
use App\Models\Materias\ReferenciasMaterias;
use Illuminate\Support\Facades\Auth;
use App\Models\Configuracoes\Configuracoes;
use App\Models\Materias\HistoricosReprovacoes;
use App\Models\Materias\ReferenciasTemas;
use Carbon\Carbon;
use App\Models\Dominios\Dominios;
use App\Helpers\ImportadorDadosWordPress;
use App\Helpers\CentralNotificacao;
use App\Models\CentralNotificacoes\CentralNotificacoes;
use App\Models\Dominios\TemasWordpress;
use App\Models\Materias\RedatorAleatorio;
use Illuminate\Support\Facades\Mail;

class MateriasController extends Controller
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
            $dados = $this->dadosMaterias($request);
            echo $dados;
            exit();
        }
        return view('materias/index');
    }

    public function getMateriasRevisar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosMaterias($request, true);
            echo $dados;
            exit();
        }
        return view('materias/materias-revisar');
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

    private function dadosMaterias($request, $somenteRevisao = false)
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

        if ($somenteRevisao) {
            $totalRecords = Materias::where('status', '=', Materias::CODIGO_STATUS_AGUARDANDO_AVALIACAO)
                ->where('leilao', 0)
                ->select('count(*) as allcount')
                ->count();
            $totalRecordswithFilter = Materias::select('count(*) as allcount')
                ->where('assunto', 'like', '%' . $searchValue . '%')
                ->where('leilao', 0)
                ->where('status', '=', Materias::CODIGO_STATUS_AGUARDANDO_AVALIACAO)
                ->count();

            // Fetch records
            $records = Materias::orderBy($columnName, $columnSortOrder)
                ->where('assunto', 'like', '%' . $searchValue . '%')
                ->where('materias.status', '=', Materias::CODIGO_STATUS_AGUARDANDO_AVALIACAO)
                ->where('leilao', 0)
                ->select('materias.*', 'users.name', 'temas.descricao as tema',  'users.tipo_redator as user_redator', 'dominios.dominio as url')
                ->leftJoin('dominios', 'dominios.id', '=', 'materias.id_dominio')
                ->leftJoin('temas', 'temas.id', '=', 'materias.tema_id')
                ->leftJoin('users', 'users.id', '=', 'materias.usuario_id')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            // Total records
            $totalRecords = Materias::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Materias::select('count(*) as allcount')
                ->where('assunto', 'like', '%' . $searchValue . '%')
                ->count();

            // Fetch records
            $records = Materias::orderBy($columnName, $columnSortOrder)
                ->where('assunto', 'like', '%' . $searchValue . '%')
                ->select('materias.*', 'users.name', 'temas.descricao as tema', 'users.tipo_redator as user_redator', 'dominios.dominio as url')
                ->leftJoin('dominios', 'dominios.id', '=', 'materias.id_dominio')
                ->leftJoin('temas', 'temas.id', '=', 'materias.tema_id')
                ->leftJoin('users', 'users.id', '=', 'materias.usuario_id')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

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
                "tema" => $tema,
                "name" => $usuario . ' - ' . $record->user_redator,
                "url" => $record->url,
                "idioma" => $record->idioma,
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

    public function getCreateEdit($id = 0, $idTema = 0)
    {
        $materia = Materias::find($id);
        $solicitacao = RedatorAleatorio::find($idTema);
        $referencias = ReferenciasMaterias::where('materia_id', '=', $id)->get();
        $temas = Temas::all();
        $temaReferencias = ReferenciasTemas::where('tema_id', '=', $idTema)->get();

        return view('materias/create-edit', compact('materia', 'temas', 'referencias', 'temaReferencias',  'solicitacao'));
    }

    public function postSalvar(Request $request)
    {
        if (!empty($request)) {
            if (isset($request['id'])) {
                $materia = Materias::find($request['id']);
                $materia->assunto = $request['assunto'];
                $materia->descricao = $request['descricao'];
                $materia->idioma = $request['idioma'];
                $materia->tema_id = $request['tema_id'];
                $materia->status = 0;
                $materia->imagem_principal = isset($request['imagem']) ? $request['imagem'] : '';
                $materia->save();
                $mensagem = 'Matéria editada com sucesso.';

                ReferenciasMaterias::where('materia_id', $request['id'])->delete();
            } else {

                $materia = new Materias;
                $materia->assunto = $request['assunto'];
                $materia->descricao = $request['descricao'];
                $materia->tema_id = $request['tema_id'];
                $materia->idioma = $request['idioma'];
                $materia->usuario_id = Auth::user()->id;

                if (isset($request->solicitacaoId)) {
                    $assunto = RedatorAleatorio::find($request->solicitacaoId);
                    $assunto->status = 4;
                    $assunto->update();
                    $materia->redator_aleatorio_id = $request->solicitacaoId;
                } else {
                    $materia->redator_aleatorio_id = 0;
                }

                if (Auth::user()->tipo_redator == "CLT") {
                    $materia->valor_post = 0;
                } else {
                    $materia->valor_post = $request['preco_materia'];
                }

                $materia->status = 0;
                $materia->imagem_principal = isset($request['imagem']) ? $request['imagem'] : '';
                $materia->save();
                $mensagem = 'Matéria adicionada com sucesso.';
            }



            if (isset($request['titulo'])) {
                for ($i = 0; $i < count($request['titulo']); $i++) {
                    $referenciaMateria = new ReferenciasMaterias;
                    $referenciaMateria->link = $request['descricao_referencia'][$i];
                    $referenciaMateria->titulo = $request['titulo'][$i];
                    $referenciaMateria->materia_id = $materia->id;
                    $referenciaMateria->tema_id = $materia->tema_id;
                    $referenciaMateria->save();
                }
            }

            return redirect('materias/minhas-materias')->with('mensagem', $mensagem);
        }

        return view('materias/minhas-materias');
    }

    public function getCreateEditLeilao($id = 0)
    {
        $materia = Materias::find($id);
        $temas = Temas::all();
        return view('materias/create-edit-leilao', compact('materia', 'temas'));
    }

    public function postSalvarLeilao(Request $request)
    {
        if (isset($request['valor_post'])) {
            $numero = str_replace('.', '', $request['valor_post']);
            $numero = str_replace(',', '.', $numero);
        }

        if (!empty($request)) {
            if (isset($request['id'])) {
                $materia = Materias::find($request['id']);
                $materia->assunto = $request['assunto'];
                $materia->descricao = $request['descricao'];
                $materia->idioma = $request['idioma'];
                $materia->tema_id = $request['tema_id'];
                $materia->valor_post = $numero;
                $materia->status = 0;
                $materia->imagem_principal = $request['imagem'];
                $materia->save();
                $mensagem = 'Matéria editada com sucesso.';
            } else {

                $materia = new Materias;
                $materia->assunto = $request['assunto'];
                $materia->descricao = $request['descricao'];
                $materia->tema_id = $request['tema_id'];
                $materia->idioma = $request['idioma'];
                $materia->usuario_id = Auth::user()->id;
                $materia->redator_aleatorio_id = 0;
                $materia->valor_post = $numero;
                $materia->status = 0;
                $materia->leilao = 1;
                $materia->imagem_principal = $request['imagem'];
                $materia->save();
                $mensagem = 'Matéria adicionada com sucesso.';
            }



            if (isset($request['titulo'])) {
                for ($i = 0; $i < count($request['titulo']); $i++) {
                    $referenciaMateria = new ReferenciasMaterias;
                    $referenciaMateria->link = $request['descricao_referencia'][$i];
                    $referenciaMateria->titulo = $request['titulo'][$i];
                    $referenciaMateria->materia_id = $materia->id;
                    $referenciaMateria->tema_id = $materia->tema_id;
                    $referenciaMateria->save();
                }
            }

            return redirect('materias/minhas-materias')->with('mensagem', $mensagem);
        }

        return view('materias/minhas-materias');
    }


    public function getExcluir($id)
    {
        $faq = Materias::find($id);
        $faq->delete();
        return redirect('materias/minhas-materias')->with('mensagem', 'Matéria excluida com sucesso.');
    }

    public function postDeletarReferencia()
    {
        $request = $this->request->all();
        $faq = ReferenciasMaterias::find($request['idUrl']);
        $faq->delete();
        echo json_encode(array('status' => 1));
        exit;
    }

    public function getMinhasMaterias()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosMinhasMaterias($request);
            echo $dados;
            exit();
        }
        return view('materias/minhas-materias');
    }

    private function dadosMinhasMaterias($request)
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
            ->where('usuario_id', '=', Auth::user()->id)
            ->where('assunto', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = Materias::orderBy($columnName, $columnSortOrder)
            ->where('usuario_id', '=', Auth::user()->id)
            ->where('assunto', 'like', '%' . $searchValue . '%')
            ->select('materias.*', 'users.name', 'temas.descricao as tema')
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
            $htmlReprovacao = ($record->status == 2) ? '<div class="m-icon"><a href="/materias/retorno-reprovacao/' . $record->id . '" title="Retorno da Reprovação"><i class="me-2 mdi mdi-playlist-remove"></i></a></div>' :
                '';
            $data_arr[] = array(
                "imagem_principal" => '<div ><img width="70"  src="' . $caminho . '"></div>',
                "assunto" => $record->assunto,
                "tema" => $record->tema,
                "name" => $record->name,
                "idioma" => $record->idioma,
                "status" => $status,
                "options" => '<div class="m-icon"><a href="/materias/create-edit/' . $record->id . '" title="Editar"><i class="me-2 mdi mdi-grease-pencil"></i></a></div>
                              <div class="m-icon"><a href="/materias/excluir/' . $record->id . '" title="Excluir"><i class="me-2 mdi mdi-delete"></i></a></div>
                              ' . $htmlReprovacao
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

    public function getVisualizarMateria($id)
    {
        $materia = Materias::where('materias.id', '=', $id)
            ->select('materias.*', 'users.name', 'temas.descricao as tema', 'users.tipo_redator', 'redator_aleatorio.qtd_palavras')
            ->leftJoin('temas', 'temas.id', '=', 'materias.tema_id')
            ->leftJoin('users', 'users.id', '=', 'materias.usuario_id')
            ->leftJoin('redator_aleatorio', 'redator_aleatorio.id', '=', 'materias.redator_aleatorio_id')
            ->get();
        $referencias = ReferenciasMaterias::where('materia_id', '=', $id)->get();
        $temas = Temas::all();
        // \dd($materia);
        // return;
        // $referencias = Referencia::where('materia_id', '=', $id)->get();
        $dominios = Dominios::all();

        return view('materias/visualizar-materia', compact('materia', 'referencias', 'dominios', 'temas'));
    }

    public function getRetornoReprovacao($id)
    {
        $materias = Materias::orderBy('historicos_reprovacoes.id', 'desc')
            ->where('materias.id', '=', $id)
            ->select('materias.*', 'users.name', 'temas.descricao as tema', 'historicos_reprovacoes.descricao as historico')
            ->leftJoin('temas', 'temas.id', '=', 'materias.tema_id')
            ->leftJoin('users', 'users.id', '=', 'materias.usuario_id')
            ->join('historicos_reprovacoes', 'historicos_reprovacoes.materia_id', '=', 'materias.id')
            ->get();

        return view('materias/retorno-reprovacao', compact('materias'));
    }

    public function getSalvarRevisao(Request $request)
    {
        $limit = ini_get('memory_limit');
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 300);

        $materia = Materias::where('materias.id', '=', $request['id'])
            ->leftJoin('users', 'users.id', '=', 'materias.usuario_id')
            ->select('materias.*', 'users.name as usuario_name', 'users.email as usuario_email')
            ->first();
        $tema_id = $request['tema_id'];

        // if ($tema_id != $materia->tema_id) {
        //     $materia->tema_id = $request['tema_id'];
        //     $materia->save();
        // }

        if ($request['status_id'] == 2) {
            $historico = new HistoricosReprovacoes();
            $historico->descricao = $request['descricao'];
            $historico->materia_id = $request['id'];
            $historico->save();

            $mensagem = 'Matéria reprovada.';
            Mail::send(new \App\Mail\reproMateria($materia));
        } else {
            $idCategoria = TemasWordpress::where('id_tema', '=', $tema_id)
                ->where('id_dominio', $request['dominio_id'])
                ->get();

            if (!isset($idCategoria[0]['id'])) {
                $categoria = Temas::find($tema_id);
                $idCategoriaWordPress = ImportadorDadosWordPress::cadastrarCategoriaWordPress($categoria->descricao, $request['dominio_id'], $tema_id);
            } else {
                $idCategoriaWordPress = $idCategoria[0]['id_categoria_wordpress'];
            }
            $idImagemWordPress = ImportadorDadosWordPress::cadastrarImagemWordPress($materia->imagem_principal, $materia->assunto, $request['dominio_id']);
            $idMateria = ImportadorDadosWordPress::cadastrarPostWordPress(
                $materia->assunto,
                $materia->descricao,
                $idCategoriaWordPress,
                $idImagemWordPress,
                $request['dominio_id']
            );
            $materia->id_wordpress = $idMateria;
            $mensagem = 'Matéria aprovada e publicada.';
            Mail::send(new \App\Mail\actMateria($materia));
        }

        CentralNotificacao::salvarNotificaoUsuario($materia->usuario_id, $mensagem, CentralNotificacoes::MODULO_MATERIAS);

        $materia->status = $request['status_id'];
        $materia->id_dominio = $request['dominio_id'];
        $materia->save();

        return redirect('materias')->with('mensagem', 'Revisão realizada com sucesso.');
    }

    public function postUpload($id = null)
    {
        if ($_FILES) {
            $files = \Request::file('file');

            $file = $this->uploadFile2($files, $_FILES['file']['name'], 'materias', '/imagem_materias');

            if ($file) {
                $json = array(
                    'res' => 1,
                    'msg' => $file,
                    'dir' => $file
                );
            } else {
                $json = array(
                    'res' => 2,
                    'msg' => 'erro ao enviar'
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
            if (
                $file->getClientOriginalExtension() == "png" ||
                $file->getClientOriginalExtension() == "jpg" ||
                $file->getClientOriginalExtension() == "ico" ||
                $file->getClientOriginalExtension() == "jpeg" ||
                $file->getClientOriginalExtension() == "gif"
            ) {
                // $nomeArquivo = $urlAmigavel;
                // $extensao = $file->getClientOriginalExtension();
                // $file->move('assets/' . $raiz . $pasta, $nomeArquivo . ".$extensao");
                // return $nomeArquivo . ".$extensao";
                $nomeArquivo = $urlAmigavel;
                // $extensao = $file->getClientOriginalExtension();
                $file->move('assets/' . $raiz . $pasta, $nomeArquivo . ".webp");
                return $nomeArquivo . ".webp";
            } else {
                $validator[] = "Permitido apenas imagem (png ou jpeg)";
                return redirect("/{$this->diretorioPrincipal}/{$this->nameView}/create")->withErrors($validator)->withInput();
            }
        }
    }

    public function urlAmigavel($Titulo)
    {
        $url_amigavel = str_slug($Titulo, "-");
        return $url_amigavel;
    }

    public function getReferencias()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosReferencias($request, true);
            echo $dados;
            exit();
        }
        return view('materias/referencias');
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
        $totalRecords = Materias::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Materias::select('count(*) as allcount')
            ->where('assunto', 'like', '%' . $searchValue . '%')
            ->count();

        // Fetch records
        $records = Materias::orderBy($columnName, $columnSortOrder)
            ->where('assunto', 'like', '%' . $searchValue . '%')
            ->select('materias.*', 'users.name', 'temas.descricao as tema', 'dominios.dominio')
            ->leftJoin('temas', 'temas.id', '=', 'materias.tema_id')
            ->leftJoin('users', 'users.id', '=', 'materias.usuario_id')
            ->leftJoin('dominios', 'dominios.id', '=', 'materias.id_dominio')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $status = Materias::STATUS_MATERIAS[$record->status];
            $tema = !empty($record->tema) ? $record->tema : 'Não Informado';
            $usuario = !empty($record->name) ? $record->name : 'Admin';
            $data_arr[] = array(
                "assunto" => $record->assunto,
                "dominio" => $record->dominio,
                "tema" => $tema,
                "name" => $usuario,
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

    public function getRelatorios()
    {
        $request = $this->request->all();
        $dominios = Dominios::all();
        $dados = [];
        $idDominio = '';
        // $tipo = $request['tipo'];


        if (!empty($request)) {
            $date = new \DateTime();
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="materias' . $date->format('d-m-Y') . '.csv";');

            $columns = array('ID', 'Site', 'URL', 'Titulo');

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $records = Materias::orderBy('materias.id', 'ASC')
                ->when($request['data_inicio'], function ($query, $data_inicio) {
                    $query->where('materias.created_at', '>=', $data_inicio);
                })
                // ->when($request['data_fim'], function ($query, $data_fim) {
                //     $query->where('materias.created_at', '<=', $data_fim);
                // })
                ->when(($request['tipo'] == 0), function ($query) {
                    $query->where('materias.exported', '=', 0);
                })
                ->when(($request['tipo'] == 1), function ($query) {
                    $query->where('materias.exported', '=', 1);
                })
                ->select('materias.*', 'users.name', 'temas.descricao as tema', 'dominios.dominio')
                ->leftJoin('temas', 'temas.id', '=', 'materias.tema_id')
                ->leftJoin('users', 'users.id', '=', 'materias.usuario_id')
                ->leftJoin('dominios', 'dominios.id', '=', 'materias.id_dominio')
                ->get();




            foreach ($records as $task) {
                $row['ID'] = $task->id_wordpress;
                $row['Site'] = $task->dominio;
                $row['URL'] = $task->dominio . '?p=' . $task->id_wordpress;
                $row['Titulo'] = utf8_decode($task->assunto);

                $materia = Materias::find($task->id);
                $materia->exported = 1;
                $materia->save();


                fputcsv($file, array($row['ID'], $row['Site'], $row['URL'], $row['Titulo']), ';');
            }
            fclose($file);

            ob_flush();
            exit();
        }
        return view('materias/relatorios', compact('dados', 'dominios', 'idDominio'));
    }
}
