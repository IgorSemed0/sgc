<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conta_id');
            $table->string('tipo');
            $table->decimal('valor');
            $table->string('descricao')->nullable();
            $table->date('data_movimento');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('conta_id')->references('id')->on('contas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimentos');
    }
};