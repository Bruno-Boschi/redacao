<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateConfiguracoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('regras_pagamento')->nullable();
            $table->decimal('valor_materia', 15, 2);
            $table->decimal('valor_minimo', 15, 2);
            $table->text('usuario_sms')->nullable();
            $table->text('senha_sms')->nullable();
            $table->integer('total_rejeitos_materia')->nullable();
            $table->time('tempo_rejeitar_materia')->nullable();
            $table->timestamps();
        });

        DB::table('configuracoes')->insert(
            array(
                [
                    'regras_pagamento' => '',
                    'valor_materia' => 10.50,
                    'valor_minimo' => 115.00,
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracoes');
    }
}
