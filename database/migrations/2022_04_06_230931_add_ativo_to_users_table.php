<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtivoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('ativo')->nullable();
            $table->string('tipo_usuario')->nullable();
            $table->string('celular')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('cpf')->nullable();
            $table->string('chave_pix')->nullable();
            $table->integer('departamento_id')->nullable();
            $table->string('tipo_redator')->nullable();
            $table->softDeletes();
        });

        DB::table('users')->insert(
            array(
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => Hash::make(1234),
                    'ativo' => 1,
                    'tipo_usuario' => 'A',
                    'departamento_id' => 0
                ]
            )
        );

        DB::table('users')->insert(
            array(
                [
                    'name' => 'Financeiro',
                    'email' => 'financeiro@admin.com',
                    'password' => Hash::make(1234),
                    'ativo' => 1,
                    'tipo_usuario' => 'A',
                    'departamento_id' => 2
                ]
            )
        );

        DB::table('users')->insert(
            array(
                [
                    'name' => 'Suporte',
                    'email' => 'suporte@admin.com',
                    'password' => Hash::make(1234),
                    'ativo' => 1,
                    'tipo_usuario' => 'A',
                    'departamento_id' => 1
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ativo');
            $table->dropColumn('tipo_usuario');
            $table->dropColumn('celular');
            $table->dropColumn('data_nascimento');
            $table->dropColumn('cpf');
            $table->dropColumn('chave_pix');
            $table->dropColumn('departamento_id');
            $table->dropColumn('tipo_redator');
            $table->dropColumn('deleted_at');
        });
    }
}
