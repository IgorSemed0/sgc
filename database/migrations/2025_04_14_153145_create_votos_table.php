<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('votacao_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('opcao_id');
            $table->dateTime('data_hora');
            $table->string('hash_voto', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('votacao_id')->references('id')->on('votacaos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('opcao_id')->references('id')->on('opcao_votacaos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('votos');
    }
};