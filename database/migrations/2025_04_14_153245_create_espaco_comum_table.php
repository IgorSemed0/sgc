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
            $table->unsignedBigInteger('condominio_id')->notNull();
            $table->string('nome')->notNull();
            $table->text('descricao')->nullable();
            $table->integer('capacidade')->notNull();
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