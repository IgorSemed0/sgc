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
            $table->string('primeiro_nome');
            $table->string('nome_meio');
            $table->string('ultimo_nome');
            $table->string('email');
            $table->string('username');
            $table->string('telefone');
            $table->string('bi');
            $table->date('data_nascimento');
            $table->string('sexo');
            $table->unsignedBigInteger('id_unidade'); 
            $table->string('tipo');
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