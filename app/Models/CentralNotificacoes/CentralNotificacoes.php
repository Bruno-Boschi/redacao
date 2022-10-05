<?php

namespace App\Models\CentralNotificacoes;

use Illuminate\Database\Eloquent\Model;

class CentralNotificacoes extends Model {
    
    protected $fillable = ['mensagem', 'usuario_id', 'status', 'data_visualizacao', 'id_aviso'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'central_notificacoes';
    
    const MODULO_FINANCEIRO = 'F';
    const MODULO_SUPORTE = 'S';
    const MODULO_MATERIAS = 'M';
    const MODULO_AVISOS = 'A';
}
