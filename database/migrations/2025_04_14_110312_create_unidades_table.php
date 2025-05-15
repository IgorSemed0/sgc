<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id(); 
            $table->string('tipo');
            $table->string('numero');
            $table->foreignId('bloco_id')->constrained('blocos')->nullable()->onDelete('cascade'); 
            $table->foreignId('edificio_id')->references('id')->on('edificios')->nullable()->onDelete('cascade'); 
            $table->integer('andar')->nullable();
            $table->string('status')->nullable();
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidades');
    }
};
