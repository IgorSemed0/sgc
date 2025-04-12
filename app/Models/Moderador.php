    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\MorphMany; // For polymorphic relations

    class Morador extends Model
    {
        use HasFactory;

        protected $table = 'morador';
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
            'data_nascimento',
            'sexo',
            'unidade_id',
            'tipo',
        ];

        protected $casts = [
            'data_nascimento' => 'date',
        ];

        // Relationships
        public function unidade(): BelongsTo
        {
            return $this->belongsTo(Unidade::class, 'unidade_id');
        }

        public function votos(): HasMany
        {
            return $this->hasMany(Voto::class, 'morador_id');
        }

        public function notificacoes(): HasMany
        {
            return $this->hasMany(Notificacao::class, 'morador_id');
        }

        public function reservasEspaco(): HasMany
        {
            return $this->hasMany(ReservaEspaco::class, 'morador_id');
        }

        // Polymorphic Relationships
        public function acessos(): MorphMany
        {
            // Assumes 'tipo_pessoa' column stores 'App\Models\Morador' or similar
            return $this->morphMany(Acesso::class, 'pessoa', 'tipo_pessoa', 'pessoa_id');
        }

        public function avisosPublicados(): MorphMany
        {
             // Assumes 'tipo_autor' column stores 'App\Models\Morador' or similar
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