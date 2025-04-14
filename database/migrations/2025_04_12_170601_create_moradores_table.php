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
        Schema::create('moradores', function (Blueprint $table) {
            $table->id();
            $table->string('primeiro_nome', 50);
            $table->string('nomes_meio', 100)->nullable();
            $table->string('ultimo_nome', 50);
            $table->string('email', 100)->unique();
            $table->string('username', 50)->unique();
            $table->string('telefone', 15)->nullable();
            $table->string('bi', 20);
            $table->date('data_nascimento')->nullable();
            $table->string('sexo', 20)->nullable();
            $table->foreignId('unidade_id')->constrained('unidades')->onDelete('cascade');
            $table->string('tipo', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moradores');
    }
};