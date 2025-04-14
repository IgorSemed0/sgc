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
            $table->string('primeiro_nome')->notNull();
            $table->string('nome_meio')->notNull();
            $table->string('ultimo_nome')->notNull();
            $table->string('bi')->unique()->notNull();
            $table->string('email')->unique()->notNull();
            $table->string('telefone');
            $table->string('motivo_visita')->notNull();
            $table->unsignedBigInteger('id_unidade')->notNull();
            $table->string('token')->unique();
            $table->date('data_entrada')->notNull();
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
