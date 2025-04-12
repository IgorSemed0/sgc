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
        Schema::create('mural_avisos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id');
            $table->string('titulo', 100);
            $table->text('conteudo');
            $table->dateTime('data_publicacao');
            $table->string('prioridade', 20)->nullable(); // Ex.: alta, media, baixa
            $table->unsignedBigInteger('autor_id'); // Foreign key handled polymorphically in Model
            $table->string('tipo_autor', 50); // Ex: Morador, Funcionario (stores Model class path)
            // No default timestamps

            $table->foreign('condominio_id')
                    ->references('id')
                    ->on('condominio')
                    ->cascadeOnDelete(); // ON DELETE CASCADE

            // Index for performance on polymorphic relation
            $table->index(['autor_id', 'tipo_autor']);
        });
    }

    /**
        * Reverse the migrations.
        */
    public function down(): void
    {
        Schema::dropIfExists('mural_avisos');
    }
};