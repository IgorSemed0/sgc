<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateEspacoComumTable extends Migration
{
    public function up()
    {
        Schema::create('espaco_comum', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->integer('capacidade');
            $table->text('regras')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('condominio_id')->references('condominio_id')->on('condominio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('espaco_comum');
    }
}