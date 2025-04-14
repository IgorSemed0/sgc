<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateOpcaoVotacaoTable extends Migration
{
    public function up()
    {
        Schema::create('opcao_votacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('votacao_id')->notNull();
            $table->string('descricao')->notNull();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('votacao_id')->references('id')->on('votacao')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('opcao_votacao');
    }
}