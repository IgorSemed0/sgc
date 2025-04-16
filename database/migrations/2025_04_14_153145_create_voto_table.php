<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateVotoTable extends Migration
{
    public function up()
    {
        Schema::create('voto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('votacao_id');
            $table->unsignedBigInteger('morador_id');
            $table->unsignedBigInteger('opcao_id');
            $table->dateTime('data_hora');
            $table->string('hash_voto', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('votacao_id')->references('id')->on('votacao')->onDelete('cascade');
            $table->foreign('morador_id')->references('id')->on('morador')->onDelete('cascade');
            $table->foreign('opcao_id')->references('id')->on('opcao_votacao')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('voto');
    }
}