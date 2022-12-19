<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Materias\Materias;
use App\Helpers\DadosRedatores;
use App\Models\CentralNotificacoes\CentralNotificacoes;
use App\Models\Suportes\Chamados;
use App\Models\Materias\RedatorAleatorio;

class DashboardController extends Controller
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
        if (Auth::user()->ativo == 0 || Auth::user()->ativo == 2) {
            Auth::logout();
            return redirect('/login')->with('mensagem', 'Usuário em avaliação ou Bloqueado.');
        }

        if (Auth::user()->tipo_usuario == 'R') {
            $materias = Materias::where('materias.usuario_id', '=', Auth::user()->id)
                ->select('materias.*', 'users.name', 'temas.descricao as tema')
                ->join('temas', 'temas.id', '=', 'materias.tema_id')
                ->join('users', 'users.id', '=', 'materias.usuario_id')
                ->take(10)
                ->get();

            $totalMateriasRevisao = Materias::select('count(*) as allcount')
                ->where('usuario_id', '=', Auth::user()->id)
                ->where('status', '=', 0)
                ->count();

            $totalMateriasAprovado = Materias::select('count(*) as allcount')
                ->where('usuario_id', '=', Auth::user()->id)
                ->where('status', '=', 3)
                ->count();

            $totalMateriasReprovado = Materias::select('count(*) as allcount')
                ->where('usuario_id', '=', Auth::user()->id)
                ->where('status', '=', 2)
                ->count();

            $assuntoRedator = RedatorAleatorio::orderBy('redator_aleatorio.created_at', 'DESC')
                // ->where('redator_aleatorio.usuario_id', '=', Auth::user()->id)
                ->whereIn(
                    'redator_aleatorio.usuario_id',
                    [Auth::user()->id, 0]


                )
                // ->whereNull('data_leitura')
                ->select('redator_aleatorio.*', 'users.name', 'temas.descricao as tema')
                ->leftJoin('temas', 'temas.id', '=', 'redator_aleatorio.tema_id')
                ->leftJoin('users', 'users.id', '=', 'redator_aleatorio.usuario_id')
                ->take(10)
                ->get();
            // \dd($assuntoRedator);

            $valorReceber = DadosRedatores::valorTotalReceber(Auth::user()->id);
            $valorTotalSolicitado = DadosRedatores::valorTotalSolicitados(Auth::user()->id);
            $valorTotalReceber = $valorReceber - $valorTotalSolicitado;
            $rankingRedatores = DadosRedatores::rankingRedatores();

            return view('dashboard/index', compact(
                'materias',
                'totalMateriasRevisao',
                'totalMateriasAprovado',
                'totalMateriasReprovado',
                'valorTotalReceber',
                'rankingRedatores',
                'assuntoRedator'
            ));
        } else {
            $ultimosChamados = Chamados::orderBy('chamados.id', 'desc')
                ->where('chamados.usuario_suporte_id', '=', Auth::user()->id)
                ->select('chamados.*', 'users.name')
                ->join('users', 'users.id', '=', 'chamados.usuario_suporte_id')
                ->take(10)
                ->get();

            $totalFechados = Chamados::select('count(*) as allcount')
                ->where('usuario_suporte_id', '=', Auth::user()->id)
                ->where('status', '=', Chamados::CODIGO_CHAMADO_FECHADO)
                ->count();

            $totalAberto = Chamados::select('count(*) as allcount')
                ->where('usuario_suporte_id', '=', Auth::user()->id)
                ->where('status', '=', Chamados::CODIGO_CHAMADO_ABERTO)
                ->count();

            $totalChamados = Chamados::select('count(*) as allcount')
                ->where('usuario_suporte_id', '=', Auth::user()->id)
                ->count();

            $rankingRedatores = DadosRedatores::rankingRedatores();

            $solicitacoes = RedatorAleatorio::leftJoin('users', 'users.id', '=', 'redator_aleatorio.usuario_id')
                ->leftJoin('temas', 'temas.id', '=', 'redator_aleatorio.tema_id')
                ->select('redator_aleatorio.*', 'users.name as usuario_nome', 'temas.descricao as temas_descricao')
                ->get();

            return view('dashboard/dashboard-admin', compact(
                'ultimosChamados',
                'totalFechados',
                'totalAberto',
                'totalChamados',
                'rankingRedatores',
                'solicitacoes'
            ));
        }
    }

    public function postCentralNotificacao()
    {
        $notificacao = CentralNotificacoes::orderBy('id', 'desc')
            ->where('usuario_id', '=', Auth::user()->id)
            ->take(10)
            ->get();

        echo json_encode(array('status' => 1, 'temas_aleatorio' => $notificacao));
        exit;
    }

    public function getRedirecionarUrl($id)
    {
        $notificacao = CentralNotificacoes::find($id);
        $urlRedirecionamento = '/dashboard';
        switch ($notificacao->modulo) {
            case "F":
                $urlRedirecionamento = '/financeiros/lista-solicitacoes-pagamento';
                break;
            case "S":
                $urlRedirecionamento = '/suportes';
                break;
            case "M":
                $urlRedirecionamento = '/materias/minhas-materias';
                break;
            case "A":
                $urlRedirecionamento = '/avisos/visualizar/' . $notificacao->id_aviso;
                break;
        }
        $date = new \DateTime();
        $notificacao->status = 1;
        $notificacao->data_visualizacao = $date->format('Y-m-d');
        $notificacao->save();

        return redirect($urlRedirecionamento);
    }
}
