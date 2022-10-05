<?php

namespace App\Models\Materias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materias extends Model {
    
    use SoftDeletes;
    
    protected $fillable = ['assunto', 'descricao', 'motivo_reprovacao', 'usuario_id', 
        'tema_id', 'status', 'valor_post', 'imagem_principal', 'id_wordpress', 'link_wordpress', 
        'slug_wordpress', 'id_dominio'];
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'materias';
    protected $dates = ['deleted_at'];
    
    const CODIGO_STATUS_AGUARDANDO_AVALIACAO = 0;
    const CODIGO_STATUS_APROVADO = 1;
    const CODIGO_STATUS_REPROVADO = 2;
    const CODIGO_STATUS_PUBLICADO = 3;
    
    const DESCRICAO_STATUS_AGUARDANDO_AVALIACAO = 'Aguardando Avaliação';
    const DESCRICAO_STATUS_APROVADO = 'Aprovado';
    const DESCRICAO_STATUS_REPROVADO = 'Reprovado';
    const DESCRICAO_STATUS_PUBLICADO = 'Publicado';
    
    const STATUS_MATERIAS = [
        self::CODIGO_STATUS_AGUARDANDO_AVALIACAO => self::DESCRICAO_STATUS_AGUARDANDO_AVALIACAO,
        self::CODIGO_STATUS_APROVADO => self::DESCRICAO_STATUS_APROVADO,
        self::CODIGO_STATUS_REPROVADO => self::DESCRICAO_STATUS_REPROVADO,
        self::CODIGO_STATUS_PUBLICADO => self::DESCRICAO_STATUS_PUBLICADO
    ];
}
