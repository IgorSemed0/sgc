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
        Schema::create('votacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id');
            $table->string('titulo', 100);
            $table->text('descricao');
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
            $table->integer('quorum_minimo')->nullable();
            $table->string('status', 20); // Ex.: aberta, fechada
            // No default timestamps

            $table->foreign('condominio_id')
                    ->references('id')
                    ->on('condominio')
                    ->cascadeOnDelete(); // ON DELETE CASCADE
        });
    }

    /**
        * Reverse the migrations.
        */
    public function down(): void
    {
        Schema::dropIfExists('votacao');
    }
};