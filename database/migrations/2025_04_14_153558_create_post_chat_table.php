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
            $table->unsignedBigInteger('condominio_id')->notNull();
            $table->unsignedBigInteger('autor_id')->notNull();
            $table->string('tipo_autor')->notNull();
            $table->string('titulo')->notNull();
            $table->text('conteudo')->notNull();
            $table->dateTime('data_publicacao')->notNull();
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