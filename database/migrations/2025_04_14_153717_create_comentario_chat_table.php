<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateComentarioChatTable extends Migration
{
    public function up()
    {
        Schema::create('comentario_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->notNull();
            $table->unsignedBigInteger('morador_id')->notNull();
            $table->text('conteudo')->notNull();
            $table->dateTime('data_comentario')->notNull();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('post_id')->references('id')->on('post_chat')->onDelete('cascade');
            $table->foreign('morador_id')->references('id')->on('morador')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentario_chat');
    }
}