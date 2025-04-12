<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voto extends Model
{
    use HasFactory;

    protected $table = 'voto';
    public $timestamps = false;

    protected $fillable = [
        'votacao_id',
        'morador_id',
        'opcao_id',
        'data_hora',
        'hash_voto',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    // Relationships
    public function votacao(): BelongsTo
    {
        return $this->belongsTo(Votacao::class, 'votacao_id');
    }

    public function morador(): BelongsTo
    {
        return $this->belongsTo(Morador::class, 'morador_id');
    }

    public function opcao(): BelongsTo
    {
        return $this->belongsTo(OpcaoVotacao::class, 'opcao_id');
    }
}