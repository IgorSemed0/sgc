<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('moradors', function (Blueprint $table) {
            $table->id(); 
            $table->string('primeiro_nome');
            $table->string('nome_meio')->nullable();
            $table->string('ultimo_nome');
            $table->string('email');
            $table->string('username')->nullable();
            $table->string('processo');
            $table->string('rf_id');
            $table->string('telefone');
            $table->string('bi');
            $table->date('data_nascimento');
            $table->string('sexo');
            $table->unsignedBigInteger('id_unidade'); 
            $table->timestamps(); 
            $table->softDeletes();
            $table->foreign('id_unidade')->references('id')->on('unidades')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('morador');
    }
};