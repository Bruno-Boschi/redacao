<?php

namespace App\Models\Idiomas;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{


    protected $fillable = ['idioma'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'idiomas_materia';
}
