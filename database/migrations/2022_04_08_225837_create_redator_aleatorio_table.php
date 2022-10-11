<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedatorAleatorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redator_aleatorio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assunto');
            $table->text('descricao')->nullable();
            $table->integer('usuario_id')->nullable();
            $table->string("idioma")->nullable();
            $table->integer('status')->nullable();
            $table->date('data_leitura')->nullable();
            $table->integer('usuario_cadastro_id')->nullable();
            $table->integer('tema_id')->nullable();
            $table->integer('qtd_palavras')->nullable();
            $table->decimal('preco_materia', 15, 2)->nullable();
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
        Schema::dropIfExists('redator_aleatorio');
    }
}
