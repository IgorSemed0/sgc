<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadeTable extends Migration
{
    public function up()
    {
        Schema::create('unidade', function (Blueprint $table) {
            $table->id(); 
            $table->string('tipo');
            $table->string('numero');
            $table->foreignId('id_bloco')->constrained('bloco')->onDelete('cascade'); 
            $table->foreignId('edificio_id')->references('edificio_id')->on('edificio')->onDelete('cascade'); 
            $table->decimal('area_m2');
            $table->string('status');
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidade');
    }
}
