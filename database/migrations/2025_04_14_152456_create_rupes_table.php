<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rupes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id');
            $table->string('descricao');
            $table->decimal('valor');
            $table->date('data_receita');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('condominio_id')->references('id')->on('condominios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rupes');
    }
};