<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'pagamento';
    public $timestamps = false;

    protected $fillable = [
        'fatura_id',
        'data_pagamento',
        'valor_pago',
        'metodo_pagamento',
        'transacao_id',
    ];

    protected $casts = [
        'data_pagamento' => 'date',
        'valor_pago' => 'decimal:2',
    ];

    // Relationship
    public function fatura(): BelongsTo
    {
        return $this->belongsTo(Fatura::class, 'fatura_id');
    }
}