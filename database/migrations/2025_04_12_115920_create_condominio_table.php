    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\DB; // Needed for DB::raw

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('condominio', function (Blueprint $table) {
                $table->id(); // INT PRIMARY KEY AUTO_INCREMENT
                $table->string('nome', 100);
                $table->string('endereco', 255);
                $table->string('cidade', 100);
                $table->string('estado', 2);
                $table->string('cep', 10);
                $table->string('telefone', 15)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('cnpj', 18)->nullable()->unique(); // Added unique constraint assuming CNPJ should be unique
                $table->date('data_fundacao')->nullable();
                // No default timestamps as per schema
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('condominio');
        }
    };