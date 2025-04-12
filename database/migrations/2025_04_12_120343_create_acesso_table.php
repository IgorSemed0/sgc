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
            Schema::create('acesso', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('pessoa_id'); // Foreign key handled polymorphically in Model
                $table->string('tipo_pessoa', 50); // Ex: Morador, Funcionario, Visitante (stores Model class path)
                $table->dateTime('data_hora');
                $table->string('tipo', 20); // Ex.: entrada, saida
                $table->string('dispositivo', 50)->nullable(); // Ex.: QR code, cartao, manual
                $table->string('observacao', 255)->nullable();
                // No default timestamps

                // Index for performance on polymorphic relation
                $table->index(['pessoa_id', 'tipo_pessoa']);
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('acesso');
        }
    };