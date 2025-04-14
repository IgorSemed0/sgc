<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateItemFaturaTable extends Migration
{
    public function up()
    {
        Schema::create('item_fatura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fatura_id')->notNull();
            $table->string('categoria')->notNull();
            $table->string('descricao')->notNull();
            $table->decimal('valor')->notNull();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fatura_id')->references('id')->on('fatura')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_fatura');
    }
}