<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ativo', 'tipo_usuario', 'celular',
        'data_nascimento', 'cpf', 'chave_pix', 'departamento_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const GRUPO_USUARIO = [
        'A' => 'Administrador',
        'R' => 'Redator'
    ];

    const STATUS_USUARIO = [
        0 => 'Bloqueado',
        1 => 'Ativo',
        2 => 'Avaliar'
    ];

    const USUARIO_ADMINISTRADOR = 'Administrador';
    const USUARIO_SUPORTE = 'Suporte';
    const USUARIO_FINANCEIRO = 'Financeiro';

    const CODIGO_USUARIO_ADMINISTRADOR = 0;
    const CODIGO_USUARIO_SUPORTE = 1;
    const CODIGO_USUARIO_FINANCEIRO = 2;

    const DEPARTAMENTO_USUARIO = [
        '' => '',
        self::CODIGO_USUARIO_ADMINISTRADOR => self::USUARIO_ADMINISTRADOR,
        self::CODIGO_USUARIO_SUPORTE => self::USUARIO_SUPORTE,
        self::CODIGO_USUARIO_FINANCEIRO => self::USUARIO_FINANCEIRO,
    ];
}
