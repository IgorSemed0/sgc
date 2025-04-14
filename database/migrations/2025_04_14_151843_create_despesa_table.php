<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateDespesaTable extends Migration
{
    public function up()
    {
        Schema::create('despesa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condominio_id')->notNull();
            $table->string('categoria')->notNull();
            $table->string('descricao')->notNull();
            $table->decimal('valor')->notNull();
            $table->date('data_despesa')->notNull();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('condominio_id')->references('condominio_id')->on('condominio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('despesa');
    }
}