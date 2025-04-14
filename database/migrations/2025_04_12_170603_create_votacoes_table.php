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
        Schema::create('votacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('condominio_id')->constrained('condominios')->onDelete('cascade');
            $table->string('titulo', 100);
            $table->text('descricao');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->integer('quorum_minimo')->nullable();
            $table->string('status', 20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votacoes');
    }
};