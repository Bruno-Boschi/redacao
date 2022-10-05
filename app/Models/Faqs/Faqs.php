<?php

namespace App\Models\Faqs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faqs extends Model {
    
    use SoftDeletes;
    
    protected $fillable = ['titulo','descricao'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'faqs';
    protected $dates = ['deleted_at'];
}
