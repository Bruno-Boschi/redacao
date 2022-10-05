<?php

namespace App\Models\Configuracoes;

use Illuminate\Database\Eloquent\Model;

class Configuracoes extends Model {
    
    protected $fillable = ['regras_pagamento','valor_materia', 'valor_minimo', 'usuario_sms', 'senha_sms',
        'total_rejeitos_materia', 'tempo_rejeitar_materia'
    ];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'configuracoes';
}
