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
        Schema::create('mensagem_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('remetente_id');
            $table->string('tipo_remetente', 50); // Ex: Morador, Funcionario
            $table->unsignedBigInteger('destinatario_id');
            $table->string('tipo_destinatario', 50); // Ex: Morador, Funcionario
            $table->text('conteudo');
            $table->dateTime('data_hora');
            $table->string('status', 20)->nullable(); // Ex.: lida, nao_lida
            // No default timestamps

                // Index for performance on polymorphic relations
            $table->index(['remetente_id', 'tipo_remetente']);
            $table->index(['destinatario_id', 'tipo_destinatario']);
        });
    }

    /**
        * Reverse the migrations.
        */
    public function down(): void
    {
        Schema::dropIfExists('mensagem_chat');
    }
};