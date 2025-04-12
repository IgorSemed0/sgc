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
            Schema::create('item_fatura', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('fatura_id');
                $table->string('categoria', 50); // Ex.: taxa condominial, agua, energia
                $table->string('descricao', 100);
                $table->decimal('valor', 10, 2);
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
            Schema::dropIfExists('item_fatura');
        }
    };