<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class CreateAcessoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acesso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pessoa_id')->notNull();
            $table->string('tipo_pessoa')->notNull();
            $table->date('data_hora')->notNull();
            $table->string('tipo')->notNull();
            $table->string('saida_dispositivo')->notNull();
            $table->string('observacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acesso');
    }
};
