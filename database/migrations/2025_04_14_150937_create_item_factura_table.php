<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateItemFacturaTable extends Migration
{
    public function up()
    {
        Schema::create('item_fatura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id');
            $table->string('categoria');
            $table->string('descricao');
            $table->decimal('valor');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('factura_id')->references('id')->on('factura')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_factura');
    }
}