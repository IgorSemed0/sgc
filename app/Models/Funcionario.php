    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\MorphMany; // For polymorphic relations

    class Funcionario extends Model
    {
        use HasFactory;

        protected $table = 'funcionario';
        public $timestamps = false;

        protected $fillable = [
            'primeiro_nome',
            'nomes_meio',
            'ultimo_nome',
            'email',
            'username',
            'telefone',
            'documento',
            'processo',
            'data_contratacao',
            'sexo',
            'cargo',
            'condominio_id',
        ];

        protected $casts = [
            'data_contratacao' => 'date',
        ];

        // Relationships
        public function condominio(): BelongsTo
        {
            return $this->belongsTo(Condominio::class, 'condominio_id');
        }

        // Polymorphic Relationships
        public function acessos(): MorphMany
        {
            // Assumes 'tipo_pessoa' column stores 'App\Models\Funcionario' or similar
            return $this->morphMany(Acesso::class, 'pessoa', 'tipo_pessoa', 'pessoa_id');
        }

         public function avisosPublicados(): MorphMany
        {
             // Assumes 'tipo_autor' column stores 'App\Models\Funcionario' or similar
            return $this->morphMany(MuralAvisos::class, 'autor', 'tipo_autor', 'autor_id');
        }

        public function mensagensEnviadas(): MorphMany
        {
            return $this->morphMany(MensagemChat::class, 'remetente', 'tipo_remetente', 'remetente_id');
        }

        public function mensagensRecebidas(): MorphMany
        {
            return $this->morphMany(MensagemChat::class, 'destinatario', 'tipo_destinatario', 'destinatario_id');
        }
    }