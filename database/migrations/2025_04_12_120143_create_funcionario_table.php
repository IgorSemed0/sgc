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
            Schema::create('funcionario', function (Blueprint $table) {
                $table->id();
                $table->string('primeiro_nome', 50);
                $table->string('nomes_meio', 100)->nullable();
                $table->string('ultimo_nome', 50);
                $table->string('email', 100)->unique();
                $table->string('username', 50)->unique();
                $table->string('telefone', 15)->nullable();
                $table->string('documento', 20); // BI
                $table->string('processo', 50)->nullable();
                $table->date('data_contratacao')->nullable();
                $table->string('sexo', 20)->nullable(); // Ex.: masculino, feminino, outro
                $table->string('cargo', 50);
                $table->unsignedBigInteger('condominio_id');
                // No default timestamps

                $table->foreign('condominio_id')
                      ->references('id')
                      ->on('condominio')
                      ->cascadeOnDelete(); // ON DELETE CASCADE
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('funcionario');
        }
    };