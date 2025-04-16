<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id');
            $table->date('data_pagamento');
            $table->decimal('valor_pago');
            $table->string('metodo_pagamento');
            $table->string('transacao_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagamento');
    }
};