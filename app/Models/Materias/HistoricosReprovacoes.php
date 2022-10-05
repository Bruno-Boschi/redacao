<?php

namespace App\Models\Materias;

use Illuminate\Database\Eloquent\Model;

class HistoricosReprovacoes extends Model {
    
    protected $fillable = ['descricao', 'materia_id'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'historicos_reprovacoes';
}
