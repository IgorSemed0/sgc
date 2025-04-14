<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePagamentoTable extends Migration
{
    public function up()
    {
        Schema::create('pagamento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id')->notNull();
            $table->date('data_pagamento')->notNull();
            $table->decimal('valor_pago')->notNull();
            $table->string('metodo_pagamento')->notNull();
            $table->string('transacao_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('factura_id')->references('id')->on('factura')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagamento');
    }
}