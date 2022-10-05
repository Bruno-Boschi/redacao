<?php

namespace App\Models\Financeiros;

use Illuminate\Database\Eloquent\Model;

class SolicitacoesSaques extends Model {
    
    protected $fillable = ['usuario_id','status', 'valor_saque', 'data_pagamento', 'comprovante'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'solicitacoes_saques';
    
    const CODIGO_PAGAMENTO_PENDENTE = 0;
    const CODIGO_PAGAMENTO_EFETUADO = 1;
    const CODIGO_PAGAMENTO_REJEITADO = 2;
    
    const PAGAMENTO_PENDENTE = 'Pendente';
    const PAGAMENTO_EFETUADO = 'Efetuado';
    const PAGAMENTO_REJEITADO = 'Rejeitado';
    
    const STATUS_SOLICITACAO = [
        self::CODIGO_PAGAMENTO_PENDENTE => self::PAGAMENTO_PENDENTE,
        self::CODIGO_PAGAMENTO_EFETUADO => self::PAGAMENTO_EFETUADO,
        self::CODIGO_PAGAMENTO_REJEITADO => self::PAGAMENTO_REJEITADO
    ];
}
