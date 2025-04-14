<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionarioTable extends Migration
{
    public function up()
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->id(); 
            $table->string('primeiro_nome')->notNull();
            $table->string('nome_meio')->notNull();
            $table->string('ultimo_nome')->notNull();
            $table->string('email')->notNull();
            $table->string('username')->notNull();
            $table->string('telefone')->notNull();
            $table->string('bi')->notNull();
            $table->string('sexo')->notNull();
            $table->string('cargo')->notNull();
            $table->unsignedBigInteger('departamento_id')->notNull(); 
            $table->unsignedBigInteger('condominio_id')->notNull();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('departamento_id')->references('departamento_id')->on('departamento')->onDelete('cascade');
            $table->foreign('condominio_id')->references('condominio_id')->on('condominio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionario');
    }
}