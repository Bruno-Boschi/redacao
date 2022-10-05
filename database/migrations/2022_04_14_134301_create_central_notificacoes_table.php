<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentralNotificacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('central_notificacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('mensagem')->nullable();
            $table->integer('usuario_id')->nullable();
            $table->integer('status')->nullable();
            $table->date('data_visualizacao')->nullable();
            $table->string('modulo')->nullable();
            $table->integer('id_aviso')->nullable();
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
        Schema::dropIfExists('central_notificacoes');
    }
}
