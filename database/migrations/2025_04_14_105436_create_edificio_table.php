<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdificioTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('edificio', function (Blueprint $table) {
            $table->id('edificio_id');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->unsignedBigInteger('bloco_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('bloco_id')->references('id')->on('bloco')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('edificio');
    }
};
