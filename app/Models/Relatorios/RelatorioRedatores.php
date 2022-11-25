<?php

namespace App\Models\Relatorios;

use Illuminate\Database\Eloquent\Model;

class RelatorioRedatores extends Model
{
    protected $table = 'relatorio_redatores';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'aceito', 'rejeitado', 'total_materias'];
}
