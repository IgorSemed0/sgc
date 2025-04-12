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
            Schema::create('visitante', function (Blueprint $table) {
                $table->id();
                $table->string('primeiro_nome', 50);
                $table->string('nomes_meio', 100)->nullable();
                $table->string('ultimo_nome', 50);
                $table->string('documento', 20); // BI
                $table->string('email', 100)->nullable();
                $table->string('telefone', 15)->nullable();
                $table->string('motivo_visita', 255)->nullable();
                $table->unsignedBigInteger('unidade_id');
                $table->dateTime('data_entrada');
                $table->dateTime('data_saida')->nullable();
                $table->string('token_acesso', 50)->nullable()->unique();
                // No default timestamps

                $table->foreign('unidade_id')
                      ->references('id')
                      ->on('unidade')
                      ->cascadeOnDelete(); // ON DELETE CASCADE
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('visitante');
        }
    };