<?php

namespace App\Models\TiposRedatores;

use Illuminate\Database\Eloquent\Model;

class TipoRedator extends Model
{


    protected $fillable = ['descricao'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'tipos_redatores';
}
