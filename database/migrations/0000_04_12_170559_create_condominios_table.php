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
        Schema::create('condominios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('endereco', 255);
            $table->string('bairro', 100)->nullable();
            $table->string('cidade', 100);
            $table->string('estado', 100);
            $table->string('telefone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condominios');
    }
};