<?php

namespace App\Models\Materias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedatorAleatorio extends Model
{

    use SoftDeletes;

    protected $fillable = ['assunto', 'descricao', 'usuario_id', 'idioma_id', 'status', 'data_leitura', 'usuario_cadastro_id', 'tema_id'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'redator_aleatorio';
    protected $dates = ['deleted_at'];

    const STATUS_ASSUNTO = [
        0 => 'Enviado',
        1 => 'Aguardando',
        2 => 'Rejeitado',
        3 => 'Aceito',
        4 => 'Finalizado',
    ];
}
