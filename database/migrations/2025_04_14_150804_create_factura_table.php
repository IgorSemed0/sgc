<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaTable extends Migration
{
    public function up()
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidade_id');
            $table->string('referencia')->nullable();
            $table->date('data_emissao');
            $table->date('data_vencimento');
            $table->decimal('valor_total');
            $table->string('status');
            $table->string('observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('unidade_id')->references('id')->on('unidade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura');
    }
}
