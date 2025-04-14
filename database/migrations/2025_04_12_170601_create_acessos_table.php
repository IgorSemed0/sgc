<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Note: pessoa_id is not a standard foreign key here, as it relates to multiple tables (polymorphic concept).
     * You might consider Laravel's built-in morphs() if you plan to use Eloquent relationships heavily.
     * Otherwise, manage the relation manually in your application code.
     */
    public function up(): void
    {
        Schema::create('acessos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pessoa_id'); // ID of morador, funcionario, or visitante
            $table->string('tipo_pessoa');
            $table->dateTime('data_hora');
            $table->string('tipo');
            $table->string('dispositivo')->nullable();
            $table->string('observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add an index for potential lookups based on person
            $table->index(['pessoa_id', 'tipo_pessoa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acessos');
    }
};