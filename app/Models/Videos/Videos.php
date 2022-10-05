<?php

namespace App\Models\Videos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Videos extends Model {
    
    use SoftDeletes;
    
    protected $fillable = ['titulo', 'video'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'videos';
    protected $dates = ['deleted_at'];
}
