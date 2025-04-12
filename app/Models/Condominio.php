   <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Condominio extends Model
    {
        use HasFactory;

        protected $table = 'condominio'; // Explicitly set table name
        public $timestamps = false; // No created_at/updated_at

        protected $fillable = [
            'nome',
            'endereco',
            'cidade',
            'estado',
            'cep',
            'telefone',
            'email',
            'cnpj',
            'data_fundacao',
        ];

        protected $casts = [
            'data_fundacao' => 'date',
        ];

        // Relationships
        public function unidades(): HasMany
        {
            return $this->hasMany(Unidade::class, 'condominio_id');
        }

        public function funcionarios(): HasMany
        {
            return $this->hasMany(Funcionario::class, 'condominio_id');
        }

        public function votacoes(): HasMany
        {
            return $this->hasMany(Votacao::class, 'condominio_id');
        }

        public function muralAvisos(): HasMany
        {
            return $this->hasMany(MuralAvisos::class, 'condominio_id');
        }

        public function espacosComuns(): HasMany
        {
            return $this->hasMany(EspacoComum::class, 'condominio_id');
        }

        public function usuarios(): HasMany
        {
            return $this->hasMany(Usuario::class, 'condominio_id');
        }
    }