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
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->string('primeiro_nome');
            $table->string('nomes_meio')->nullable();
            $table->string('ultimo_nome');
            $table->string('bi');
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('motivo_visita')->nullable();
            $table->foreignId('unidade_id')->constrained('unidades')->onDelete('cascade');
            $table->string('token_acesso')->unique()->nullable();
            $table->dateTime('data_entrada');
            $table->dateTime('data_saida')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitantes');
    }
};