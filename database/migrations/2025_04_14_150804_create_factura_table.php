<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturaTable extends Migration
{
    public function up()
    {
        Schema::create('fatura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidade_id')->notNull();
            $table->string('referencia')->nullable();
            $table->date('data_emissao')->notNull();
            $table->date('data_vencimento')->notNull();
            $table->decimal('valor_total')->notNull();
            $table->string('status')->notNull();
            $table->string('observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('unidade_id')->references('id')->on('unidade_id')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fatura');
    }
}
