<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateVotacaoTable extends Migration
{
    public function up()
    {
        Schema::create('votacao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id')->notNull();
            $table->string('titulo')->notNull();
            $table->text('descricao')->notNull();
            $table->dateTime('data_inicio')->notNull();
            $table->dateTime('data_fim')->notNull();
            $table->integer('quorum_minimo')->nullable();
            $table->string('status')->notNull();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('condominio_id')->references('condominio_id')->on('condominio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('votacao');
    }
}