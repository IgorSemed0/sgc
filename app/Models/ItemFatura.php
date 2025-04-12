    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class ItemFatura extends Model
    {
        use HasFactory;

        protected $table = 'item_fatura';
        public $timestamps = false;

        protected $fillable = [
            'fatura_id',
            'categoria',
            'descricao',
            'valor',
        ];

        protected $casts = [
            'valor' => 'decimal:2',
        ];

        // Relationship
        public function fatura(): BelongsTo
        {
            return $this->belongsTo(Fatura::class, 'fatura_id');
        }
    }