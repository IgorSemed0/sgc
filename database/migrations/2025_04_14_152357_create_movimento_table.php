<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateMovimentoTable extends Migration
{
    public function up()
    {
        Schema::create('movimento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conta_id')->notNull();
            $table->string('tipo')->notNull();
            $table->decimal('valor')->notNull();
            $table->string('descricao')->nullable();
            $table->date('data_movimento')->notNull();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('conta_id')->references('id')->on('conta')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimento');
    }
}