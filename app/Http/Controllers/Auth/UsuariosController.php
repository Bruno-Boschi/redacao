<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\FormataData;
use App\Models\TiposRedatores\TipoRedator;
use App\Models\TiposRedatores\TiposRedatores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
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
    }

    public function show($id)
    {
        //
    }

    public function index()
    {
    }

    public function postCadastro()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $verificaUsuario = User::select('count(*) as allcount')->where('email', '=', trim($request['email']))->count();
            $verificaCpf = User::select('count(*) as allcount')->where('cpf', '=', trim($request['cpf']))->count();
            if (($verificaUsuario > 0) || ($verificaCpf > 0)) {
                $data = ($verificaUsuario > 0) ? "E-mail já possui cadastro no sistema." :
                    "CPF já possui cadastro no sistema";
                return view('/auth/register', compact('data'));
            } else {
                $usuario = new User;
                $usuario->name = $request['nome'];
                $usuario->email = $request['email'];
                $usuario->password = Hash::make($request['password']);
                $usuario->ativo = 2;
                $usuario->tipo_usuario = $request['tipo'];
                $usuario->celular = $request['celular'];
                $usuario->data_nascimento = FormataData::dataBrParaDb($request['dt_nascimento']);
                $usuario->cpf = $request['cpf'];
                $usuario->chave_pix = $request['chave_pix'];
                $usuario->save();
                return redirect()->route('login');
            }
        }
    }

    public function getRedatores()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosUsuarios($request, 'R');
            echo $dados;
            exit();
        }
        return view('usuarios/redatores');
    }

    public function getPublishers()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosUsuarios($request, 'P');
            echo $dados;
            exit();
        }
        return view('usuarios/publishers');
    }

    public function getAdministradores()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $dados = $this->dadosUsuarios($request, 'A');
            echo $dados;
            exit();
        }
        return view('usuarios/administradores');
    }

    public function getExcluir($id)
    {
        $usuario = User::find($id);
        $usuario->delete();
        if ($usuario->tipo_usuario == 'R') {
            return redirect('usuarios/redatores')->with('mensagem', 'Redator excluido com sucesso.');
        } else {
            return redirect('usuarios/administradores')->with('mensagem', 'Administrador excluido com sucesso.');
        }
    }

    public function getBloquear($id, $status)
    {
        $usuario = User::find($id);
        $usuario->ativo = ($status == 0) ? 1 : 0;
        $usuario->save();
        if ($usuario->tipo_usuario == 'R') {
            return redirect('usuarios/redatores')->with('mensagem', 'Status alterado com sucesso.');
        } else {
            return redirect('usuarios/administradores')->with('mensagem', 'Status alterado com sucesso.');
        }
    }

    private function dadosUsuarios($request, $tipoUsuario)
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
        $totalRecords = User::select('count(*) as allcount')
            ->where('tipo_usuario', '=', $tipoUsuario)
            ->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')
            ->where(function ($query) use ($tipoUsuario, $searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
            })
            ->where('tipo_usuario', '=', $tipoUsuario)
            ->count();

        // Fetch records
        $records = User::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($tipoUsuario, $searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
            })
            ->where('tipo_usuario', '=', $tipoUsuario)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $status = User::STATUS_USUARIO[$record->ativo];
            $departamentoId = User::DEPARTAMENTO_USUARIO[$record->departamento_id];
            $descritivoAtivo = (($record->ativo == 0) ? 'Ativar' : ($record->ativo == 2)) ? 'Avaliar' : 'Bloqueados';
            $iconeAtivo = ($record->ativo == 0) ? 'mdi mdi-account-check' : 'mdi mdi-account-off';
            $data_arr[] = array(
                "name" => $record->name,
                "email" => $record->email,
                "celular" => $record->celular,
                "data_nascimento" => FormataData::dataDbParaBr($record->data_nascimento),
                "tipo_redator" => ($record->tipo_redator) ? $record->tipo_redator : "",
                "ativo" => $status,
                "departamento_id" => $departamentoId,
                "options" => ($record->ativo == 2) ? '<div class="m-icon"><a href="/usuarios/create-edit/' . $record->tipo_usuario . '/' . $record->id . '" title="Avaliar"><i class="me-2 mdi mdi-comment-alert-outline"></i></a></div>' : '<div class="m-icon"><a href="/usuarios/create-edit/' . $record->tipo_usuario . '/' . $record->id . '" title="Editar"><i class="me-2 mdi mdi-grease-pencil"></i></a></div>
                              <div class="m-icon"><a href="/usuarios/bloquear/' . $record->id . '/' . $record->ativo . '" title="' . $descritivoAtivo . '"><i class="me-2 ' . $iconeAtivo . '"></i></a></div>'
                //                              <div class="m-icon"><a href="/usuarios/excluir/'.$record->id.'" title="Excluir"><i class="me-2 mdi mdi-delete"></i></a></div>

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

    public function getCreateEdit($tipoUsuario, $id = 0)
    {
        $usuario = User::find($id);
        $departamentos = User::DEPARTAMENTO_USUARIO;

        return view('usuarios/create-edit', compact('usuario', 'tipoUsuario', 'departamentos'));
    }

    public function getSalvar()
    {
        $request = $this->request->all();
        if (!empty($request)) {
            $usuarioCadastrado = User::where('email', '=', $request['email'])
                ->orWhere('cpf', '=', $request['cpf'])->count();
            if (($usuarioCadastrado > 0) && (!isset($request['id']))) {
                $erro = 'Usuário já possui cadastrado.';
                return redirect('usuarios/administradores')->with('erro', $erro);
            }
            if (isset($request['id'])) {
                $usuario = User::find($request['id']);
                $usuario->name = $request['name'];
                $usuario->email = $request['email'];
                $usuario->tipo_usuario = $request['tipo_usuario'];
                $usuario->celular = $request['celular'];
                $usuario->data_nascimento = FormataData::dataBrParaDb($request['data_nascimento']);
                $usuario->cpf = $request['cpf'];
                $usuario->chave_pix = $request['chave_pix'];
                $usuario->ativo = ($usuario->ativo == 2) ? 1 : $usuario->ativo;

                if (isset($request['tipo_redator'])) {
                    $usuario->tipo_redator = $request['tipo_redator'];
                }

                if (isset($request['departamento'])) {
                    $usuario->departamento_id = $request['departamento'];
                }
                if (!empty(trim($request['password']))) {
                    $usuario->password = Hash::make($request['password']);
                }
                $usuario->save();
                // \dd($usuario);
                $mensagem = 'Usuário editado com sucesso.';
            } else {
                $usuario = new User;
                $usuario->name = $request['name'];
                $usuario->email = $request['email'];
                $usuario->password = Hash::make($request['password']);
                $usuario->ativo = 1;
                $usuario->tipo_usuario = $request['tipo_usuario'];
                $usuario->celular = $request['celular'];
                $usuario->data_nascimento = FormataData::dataBrParaDb($request['data_nascimento']);
                $usuario->cpf = $request['cpf'];
                $usuario->chave_pix = $request['chave_pix'];
                if (isset($request['departamento'])) {
                    $usuario->departamento_id = $request['departamento'];
                }

                if (isset($request['tipo_redator'])) {
                    $usuario->tipo_redator = $request['tipo_redator'];
                }

                if (isset($request['preco_materia'])) {
                    $numero = str_replace('.', '', $request['preco_materia']);
                    $numero = str_replace(',', '.', $numero);
                    $usuario->preco_materia = $numero;
                }
                $usuario->save();
                // \dd($usuario);
                $mensagem = 'Usuário cadastrado com sucesso.';
            }
            if ($request['tipo_usuario'] == 'R') {
                if (Auth::user()->tipo_usuario == 'R') {
                    return redirect('dashboard');
                }
                return redirect('usuarios/redatores')->with('mensagem', $mensagem);
            } else if ($request['tipo_usuario'] == 'A') {
                return redirect('usuarios/administradores')->with('mensagem', $mensagem);
            } else if ($request['tipo_usuario'] == 'P') {
                return redirect('usuarios/publishers')->with('mensagem', $mensagem);
            }
        }

        return view('usuarios');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
