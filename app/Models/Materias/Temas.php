<?php

namespace App\Models\Materias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Temas extends Model {
    
    use SoftDeletes;
    
    protected $fillable = ['descricao'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'temas';
    protected $dates = ['deleted_at'];
}
