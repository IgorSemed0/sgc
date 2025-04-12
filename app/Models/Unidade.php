    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Unidade extends Model
    {
        use HasFactory;

        protected $table = 'unidade';
        public $timestamps = false;

        protected $fillable = [
            'tipo',
            'numero',
            'bloco',
            'andar',
            'area_m2',
            'status',
            'condominio_id',
        ];

        protected $casts = [
            'area_m2' => 'decimal:2',
            'andar' => 'integer',
        ];

        // Relationships
        public function condominio(): BelongsTo
        {
            return $this->belongsTo(Condominio::class, 'condominio_id');
        }

        public function moradores(): HasMany
        {
            return $this->hasMany(Morador::class, 'unidade_id');
        }

        public function visitantes(): HasMany
        {
            return $this->hasMany(Visitante::class, 'unidade_id');
        }

        public function faturas(): HasMany
        {
            return $this->hasMany(Fatura::class, 'unidade_id');
        }
    }