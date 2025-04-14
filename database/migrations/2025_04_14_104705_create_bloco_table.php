<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloco', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->notNull();
            $table->string('descricao')->nullable();
            $table->unsignedBigInteger('condominio_id')->notNull();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('condominio_id')->references('condominio_id')->on('condominio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('bloco');
    }
}
