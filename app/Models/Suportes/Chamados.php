<?php

namespace App\Models\Suportes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamados extends Model {
    
    protected $fillable = ['titulo','usuario_id', 'status', 'departamento_id', 'data_fechamento', 'usuario_suporte_id'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'chamados';
    
    const CODIGO_CHAMADO_ABERTO = 0;
    const CODIGO_CHAMADO_AGUARDANDO_RESPOSTA = 1;
    const CODIGO_CHAMADO_FECHADO = 2;
    
    const CHAMADO_ABERTO = 'Aberto';
    const CHAMADO_AGUARDANDO_RESPOSTA = 'Aguardando Resposta';
    const CHAMADO_FECHADO = 'Fechado';
    
    const STATUS_CHAMADO = [
        self::CODIGO_CHAMADO_ABERTO => self::CHAMADO_ABERTO,
        self::CODIGO_CHAMADO_AGUARDANDO_RESPOSTA => self::CHAMADO_AGUARDANDO_RESPOSTA,
        self::CODIGO_CHAMADO_FECHADO => self::CHAMADO_FECHADO
    ];
}
