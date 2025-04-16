<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('opcao_votacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('votacao_id');
            $table->string('descricao');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('votacao_id')->references('id')->on('votacaos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('opcao_votacaos');
    }
};