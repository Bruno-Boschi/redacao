<?php

namespace App\Models\Dominios;

use Illuminate\Database\Eloquent\Model;

class  FaturamentoDominio extends Model {
    
    protected $fillable = ['impressoes', 'cliques', 'valor_impressao', 'data_busca', 'id_wordpress', 'dominio_id', 'id_domain'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'faturamento_dominio';
}
