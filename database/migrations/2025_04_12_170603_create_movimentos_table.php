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
        Schema::create('movimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conta_id')->constrained('contas')->onDelete('cascade');
            $table->string('tipo');
            $table->decimal('valor');
            $table->string('descricao', 255)->nullable();
            $table->date('data_movimento');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentos');
    }
};