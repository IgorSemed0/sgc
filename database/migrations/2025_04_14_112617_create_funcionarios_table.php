<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id(); 
            $table->string('primeiro_nome');
            $table->string('nomes_meio')->nullable();
            $table->string('ultimo_nome');
            $table->string('email');
            $table->string('username')->nullable();
            $table->string('telefone');
            $table->string('bi');
            $table->string('sexo');
            $table->string('cargo');
            $table->unsignedBigInteger('departamento_id'); 
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
};