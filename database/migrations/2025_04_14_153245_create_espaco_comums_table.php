<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('espaco_comums', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $$table->foreignId('bloco_id')->constrained('blocos')->onDelete('cascade');
            $table->text('descricao')->nullable();
            $table->text('regras')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('espaco_comums');
    }
};