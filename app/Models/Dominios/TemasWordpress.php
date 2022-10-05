<?php

namespace App\Models\Dominios;

use Illuminate\Database\Eloquent\Model;

class TemasWordpress extends Model {
    
    protected $fillable = ['id_dominio', 'id_tema', 'id_categoria_wordpress'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'temas_wordpress';
}
