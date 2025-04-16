<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitanteTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitante', function (Blueprint $table) {
            $table->id();
            $table->string('primeiro_nome');
            $table->string('nome_meio');
            $table->string('ultimo_nome');
            $table->string('bi')->unique();
            $table->string('email')->unique();
            $table->string('telefone');
            $table->string('motivo_visita');
            $table->unsignedBigInteger('id_unidade');
            $table->string('token')->unique();
            $table->date('data_entrada');
            $table->timestamps();
            $table->softDeletes();    
            $table->foreign('id_unidade')->references('id')->on('unidade')->onDelete('cascade');
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
