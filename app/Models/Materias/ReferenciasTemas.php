<?php

namespace App\Models\Materias;

use Illuminate\Database\Eloquent\Model;

class ReferenciasTemas extends Model {
    
    protected $fillable = ['titulo', 'descricao', 'tema_id', 'materia_id'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'referencias_temas';
}
