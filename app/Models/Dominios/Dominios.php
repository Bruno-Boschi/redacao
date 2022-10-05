<?php

namespace App\Models\Dominios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dominios extends Model {
    
    use SoftDeletes;
    
    protected $fillable = ['dominio', 'usuario_dominio', 'senha_dominio'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'dominios';
    protected $dates = ['deleted_at'];
}
