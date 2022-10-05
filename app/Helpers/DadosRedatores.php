<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Materias\RedatorAleatorio;

class DadosRedatores
{
    public static function valorTotalReceber($usuarioId)
    {
        $sql = 'SELECT SUM(valor_post) valor_total FROM materias WHERE usuario_id = ' . $usuarioId . ' AND status = 3';
        $records = \DB::select($sql);

        return $records[0]->valor_total;
    }

    public static function rankingRedatores()
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
                       users.name
                FROM materias
                INNER JOIN users ON users.id = materias.usuario_id
                WHERE materias.deleted_at is null
                GROUP BY usuario_id, users.name
                LIMIT 10;';
        $records = \DB::select($sql);

        return $records;
    }

    public static function valorTotalSolicitados($usuarioId)
    {
        $sql = 'SELECT SUM(valor_saque) valor_total FROM solicitacoes_saques WHERE usuario_id = ' . $usuarioId;
        $records = \DB::select($sql);

        return $records[0]->valor_total;
    }

    public static function totalMateriaisRejeitasDiaria($idUsuario)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d');

        $totalRejeicoes = RedatorAleatorio::where('usuario_id', '=', $idUsuario)
            ->where(DB::raw('date(created_at)'), '=', $dataAtual)
            ->where('status', '=', 2)
            ->count();
        return $totalRejeicoes;
    }
}
