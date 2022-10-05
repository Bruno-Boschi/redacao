<?php
namespace App\Helpers;

use App\Models\CentralNotificacoes\CentralNotificacoes;
use App\User;

class SelecionarUsuario
{
    public static function proximoUsuarioCadastrarMensagemSuporte($usuarioAtual, $departamento) {
        $ultimoUsuarioSuporte = CentralNotificacoes::orderBy('id', 'desc')->first();
        if (empty($ultimoUsuarioSuporte)) {
            $usuarioAtual = 0;
            $ultimoUsuarioSuporte = 0;
        } else {
            $ultimoUsuarioSuporte = $ultimoUsuarioSuporte->usuario_id;
        }
        
        if ($usuarioAtual == 0) {
            $usuario = User::where('id', '>', $ultimoUsuarioSuporte)
                ->where('ativo', '=', '1')
                ->where('tipo_usuario', '=', 'A')
                ->where('departamento_id', '=', $departamento)
                ->orderBy('id', 'asc')
                ->first();
            if (empty($usuario)) {
                $usuario = User::where('ativo', '=', '1')
                    ->where('tipo_usuario', '=', 'A')
                    ->where('departamento_id', '=', $departamento)
                    ->orderBy('id', 'asc')
                    ->first();
            }
        } else {
            $usuario = User::where('id', '>', $usuarioAtual)
                ->where('ativo', '=', '1')
                ->where('tipo_usuario', '=', 'A')
                ->where('departamento_id', '=', $departamento)
                ->orderBy('id', 'asc')
                ->first();
        }
        
        
        if ($ultimoUsuarioSuporte == $usuario->id) {
            $usuario = User::where('ativo', '=', '1')
            ->where('tipo_usuario', '=', 'A')
            ->where('departamento_id', '=', $departamento)
            ->orderBy('id', 'asc')
            ->first();
        }
        
        return $usuario->id;
    }
}

