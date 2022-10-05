<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacoesSaquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacoes_saques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usuario_id')->nullable();
            $table->integer('status')->nullable();
            $table->decimal('valor_saque', 15, 2);
            $table->date('data_pagamento')->nullable();
            $table->string('comprovante')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitacoes_saques');
    }
}
