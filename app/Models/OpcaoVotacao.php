<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpcaoVotacao extends Model
{
    use HasFactory;

    protected $table = 'opcao_votacao';
    public $timestamps = false;

    protected $fillable = [
        'votacao_id',
        'descricao',
    ];

    // Relationships
    public function votacao(): BelongsTo
    {
        return $this->belongsTo(Votacao::class, 'votacao_id');
    }

    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class, 'opcao_id');
    }
}