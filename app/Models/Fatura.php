    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne; // Assuming one payment per fatura, adjust if multiple partial payments are possible

    class Fatura extends Model
    {
        use HasFactory;

        protected $table = 'fatura';
        public $timestamps = false;

        protected $fillable = [
            'unidade_id',
            'referencia',
            'data_emissao',
            'data_vencimento',
            'valor_total',
            'status',
            'observacao',
        ];

        protected $casts = [
            'data_emissao' => 'date',
            'data_vencimento' => 'date',
            'valor_total' => 'decimal:2',
        ];

        // Relationships
        public function unidade(): BelongsTo
        {
            return $this->belongsTo(Unidade::class, 'unidade_id');
        }

        public function itensFatura(): HasMany
        {
            return $this->hasMany(ItemFatura::class, 'fatura_id');
        }

        // If one fatura can have multiple payments (e.g., partial), use HasMany
        public function pagamentos(): HasMany
        {
             return $this->hasMany(Pagamento::class, 'fatura_id');
        }

        // If one fatura maps strictly to one payment record (even if value differs), use HasOne
        // public function pagamento(): HasOne
        // {
        //     return $this->hasOne(Pagamento::class, 'fatura_id');
        // }
    }