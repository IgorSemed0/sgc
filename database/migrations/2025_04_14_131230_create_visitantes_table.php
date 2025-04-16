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
            $table->string('bi')->unique();
            $table->string('email')->unique();
            $table->string('telefone');
            $table->string('condominio_id');
            $table->string('motivo_visita');
            $table->unsignedBigInteger('unidade_id');
            $table->date('data_entrada');
            $table->date('data_saida');
            $table->timestamps();
            $table->softDeletes();    
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitante');
    }
};
