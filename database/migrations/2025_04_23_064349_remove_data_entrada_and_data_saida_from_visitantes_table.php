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
        Schema::table('visitantes', function (Blueprint $table) {
            $table->dropColumn(['data_entrada', 'data_saida']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitantes', function (Blueprint $table) {
            $table->date('data_entrada')->nullable();
            $table->date('data_saida')->nullable();
        });
    }
};