<?php

namespace App\Models\Suportes;

use Illuminate\Database\Eloquent\Model;

class ChamadoDetalhes extends Model {
    
    protected $fillable = ['mensagem','chamado_id', 'tipo_mensagem', 'usuario_id'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'chamado_detalhes';
}
