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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('primeiro_nome');
            $table->string('nomes_meio')->nullable();
            $table->string('ultimo_nome');
            $table->string('processo');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('telefone')->nullable();
            $table->string('bi');
            $table->string('sexo')->nullable();
            $table->string('cargo');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->onDelete('set null');
            $table->foreignId('condominio_id')->constrained('condominios')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};