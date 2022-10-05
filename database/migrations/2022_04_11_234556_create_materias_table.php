<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assunto');
            $table->text('descricao');
            $table->text('motivo_reprovacao')->nullable();
            $table->string('idioma')->nullable();
            $table->integer('usuario_id')->nullable();
            $table->integer('tema_id')->nullable();
            $table->integer('status')->nullable();
            $table->decimal('valor_post', 15, 2);
            $table->text('imagem_principal')->nullable();
            $table->integer('id_wordpress')->nullable();
            $table->string('link_wordpress')->nullable();
            $table->string('slug_wordpress')->nullable();
            $table->string('id_dominio')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('materias');
    }
}
