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
        Schema::create('reserva_espacos', function (Blueprint $table) {
            $table->id();
            $table->date('data_reserva');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->string('status');
            $table->string('observacao')->nullable();
            $table->foreignId('espaco_id')->constrained('espaco_comuns')->onDelete('cascade');
            $table->foreignId('morador_id')->constrained('moradores')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_espacos');
    }
};