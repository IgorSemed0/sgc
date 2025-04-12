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
            Schema::create('unidade', function (Blueprint $table) {
                $table->id();
                $table->string('tipo', 50); // Ex.: apartamento, vaga, loja, outro
                $table->string('numero', 10);
                $table->string('bloco', 10)->nullable();
                $table->integer('andar')->nullable();
                $table->decimal('area_m2', 10, 2)->nullable();
                $table->string('status', 20); // Ex.: alugada, vendida, disponivel
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
            Schema::dropIfExists('unidade');
        }
    };