<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateReservaEspacoTable extends Migration
{
    public function up()
    {
        Schema::create('reserva_espaco', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('espaco_id');
            $table->unsignedBigInteger('morador_id');
            $table->date('data_reserva');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->string('status');
            $table->string('observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('espaco_id')->references('id')->on('espaco_comum')->onDelete('cascade');
            $table->foreign('morador_id')->references('id')->on('morador')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reserva_espaco');
    }
}