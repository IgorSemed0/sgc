<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 50);
            $table->string('numero', 10);
            $table->foreignId('bloco_id')->constrained('blocos')->onDelete('cascade');
            $table->foreignId('edificio_id')->nullable()->constrained('edificios')->onDelete('set null');
            $table->integer('andar')->nullable();
            $table->decimal('area_m2', 10, 2)->nullable();
            $table->string('status', 20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades');
    }
};