<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('morador_id');
            $table->text('conteudo');
            $table->dateTime('data_comentario');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('post_id')->references('id')->on('chat_posts')->onDelete('cascade');
            $table->foreign('morador_id')->references('id')->on('moradors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentario_chat');
    }
};