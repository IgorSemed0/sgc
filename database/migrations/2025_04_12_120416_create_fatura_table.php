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
            Schema::create('fatura', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('unidade_id');
                $table->string('referencia', 10)->nullable(); // Ex.: 2025-04
                $table->date('data_emissao');
                $table->date('data_vencimento');
                $table->decimal('valor_total', 10, 2);
                $table->string('status', 20); // Ex.: paga, pendente, atrasada
                $table->string('observacao', 255)->nullable();
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
            Schema::dropIfExists('fatura');
        }
    };