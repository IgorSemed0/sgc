<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Note: autor_id is not a standard foreign key here (polymorphic concept).
     * You might consider Laravel's built-in morphs() for 'author'.
     */
    public function up(): void
    {
        Schema::create('post_chats', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_autor');
            $table->string('titulo');
            $table->text('conteudo');
            $table->dateTime('data_publicacao');
            $table->foreignId('condominio_id')->constrained('condominios')->onDelete('cascade');
            $table->unsignedBigInteger('autor_id');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['autor_id', 'tipo_autor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_chats');
    }
};