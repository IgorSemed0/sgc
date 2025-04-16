<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateContaTable extends Migration
{
    public function up()
    {
        Schema::create('conta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id');
            $table->string('nome');
            $table->string('tipo');
            $table->decimal('saldo', 10, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('condominio_id')->references('condominio_id')->on('condominio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conta');
    }
}