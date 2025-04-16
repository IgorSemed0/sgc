<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePostChatTable extends Migration
{
    public function up()
    {
        Schema::create('post_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id');
            $table->unsignedBigInteger('autor_id');
            $table->string('tipo_autor');
            $table->string('titulo');
            $table->text('conteudo');
            $table->dateTime('data_publicacao');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('condominio_id')->references('condominio_id')->on('condominio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_chat');
    }
}