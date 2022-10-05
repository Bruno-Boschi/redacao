<?php
namespace App\Helpers;

use App\Models\CentralNotificacoes\CentralNotificacoes;
use App\User;

class CentralNotificacao
{
    public static function salvarNotificaoUsuario($usuario, $mensagem, $modulo) 
    {
        $notificacao = new CentralNotificacoes;
        $notificacao->mensagem = $mensagem;
        $notificacao->usuario_id = $usuario;
        $notificacao->modulo = $modulo;
        $notificacao->status = 0;
        $notificacao->save();
    }
    
    public static function enviarNotificacaoMassaRedatores($titulo, $idAviso)
    {
        $usuarios = User::where('ativo', '=', 1)->where('tipo_usuario', '=', 'R')->get();
        foreach ($usuarios as $usuario) {
            $notificacao = new CentralNotificacoes;
            $notificacao->mensagem = $titulo;
            $notificacao->usuario_id = $usuario['id'];
            $notificacao->modulo = CentralNotificacoes::MODULO_AVISOS;
            $notificacao->status = 0;
            $notificacao->id_aviso = $idAviso;
            $notificacao->save();
        }
    }
}

