<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaturamentoDominioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faturamento_dominio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('impressoes')->nullable();
            $table->integer('cliques')->nullable();
            $table->decimal('valor_impressao', 15, 2);
            $table->date('data_busca')->nullable();
            $table->integer('id_wordpress')->nullable();
            $table->integer('dominio_id')->nullable();
            $table->integer('id_domain')->nullable();
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
        Schema::dropIfExists('faturamento_dominio');
    }
}
