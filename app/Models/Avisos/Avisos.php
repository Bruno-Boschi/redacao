<?php

namespace App\Models\Avisos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avisos extends Model {
    
    use SoftDeletes;
    
    protected $fillable = ['titulo','descricao'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'avisos';
    protected $dates = ['deleted_at'];
}
