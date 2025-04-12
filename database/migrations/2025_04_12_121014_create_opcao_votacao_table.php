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
            Schema::create('opcao_votacao', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('votacao_id');
                $table->string('descricao', 100);
                // No default timestamps

                $table->foreign('votacao_id')
                      ->references('id')
                      ->on('votacao')
                      ->cascadeOnDelete(); // ON DELETE CASCADE
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('opcao_votacao');
        }
    };