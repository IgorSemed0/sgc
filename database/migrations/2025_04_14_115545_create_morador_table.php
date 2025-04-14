<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoradorTable extends Migration
{
    public function up()
    {
        Schema::create('morador', function (Blueprint $table) {
            $table->id(); 
            $table->string('primeiro_nome')->notNull();
            $table->string('nome_meio')->notNull();
            $table->string('ultimo_nome')->notNull();
            $table->string('email')->notNull();
            $table->string('username')->notNull();
            $table->string('telefone')->notNull();
            $table->string('bi')->notNull();
            $table->date('data_nascimento')->notNull();
            $table->string('sexo')->notNull();
            $table->unsignedBigInteger('id_unidade')->notNull(); 
            $table->string('tipo')->notNull();
            $table->timestamps(); 
            $table->softDeletes();
            $table->foreign('id_unidade')->references('id')->on('unidade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('morador');
    }
}