<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('votacao_id')->constrained('votacoes')->onDelete('cascade');
            $table->foreignId('morador_id')->constrained('moradores')->onDelete('cascade');
            $table->foreignId('opcao_id')->constrained('opcao_votacoes')->onDelete('cascade');
            $table->dateTime('data_hora');
            $table->string('hash_voto', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['votacao_id', 'morador_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votos');
    }
};