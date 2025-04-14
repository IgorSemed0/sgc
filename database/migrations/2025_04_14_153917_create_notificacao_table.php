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
            $table->unsignedBigInteger('morador_id')->notNull();
            $table->string('tipo')->notNull();
            $table->string('titulo')->notNull();
            $table->text('conteudo')->notNull();
            $table->dateTime('data_hora')->notNull();
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