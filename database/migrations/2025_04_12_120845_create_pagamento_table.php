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
            Schema::create('pagamento', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('fatura_id');
                $table->date('data_pagamento');
                $table->decimal('valor_pago', 10, 2);
                $table->string('metodo_pagamento', 50); // Ex.: boleto, cartao, transferencia
                $table->string('transacao_id', 100)->nullable()->index(); // Added index for potential lookups
                // No default timestamps

                $table->foreign('fatura_id')
                      ->references('id')
                      ->on('fatura')
                      ->cascadeOnDelete(); // ON DELETE CASCADE
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('pagamento');
        }
    };