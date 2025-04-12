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
        Schema::create('voto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('votacao_id');
            $table->unsignedBigInteger('morador_id');
            $table->unsignedBigInteger('opcao_id');
            $table->dateTime('data_hora');
            $table->string('hash_voto', 255)->nullable()->index(); // Added index for potential lookups
            // No default timestamps

            $table->foreign('votacao_id')
                    ->references('id')
                    ->on('votacao')
                    ->cascadeOnDelete(); // ON DELETE CASCADE

            $table->foreign('morador_id')
                    ->references('id')
                    ->on('morador')
                    ->cascadeOnDelete(); // ON DELETE CASCADE

            $table->foreign('opcao_id')
                    ->references('id')
                    ->on('opcao_votacao')
                    ->cascadeOnDelete(); // ON DELETE CASCADE

            // Optional: Ensure a resident votes only once per poll
            // $table->unique(['votacao_id', 'morador_id']);
        });
    }

    /**
        * Reverse the migrations.
        */
    public function down(): void
    {
        Schema::dropIfExists('voto');
    }
};