<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateNotificacaoTable extends Migration
{
    public function up()
    {
        Schema::create('notificacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('morador_id');
            $table->string('tipo');
            $table->string('titulo');
            $table->text('conteudo');
            $table->dateTime('data_hora')();
            $table->boolean('lida')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('morador_id')->references('id')->on('morador')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacao');
    }
}