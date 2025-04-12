<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Votacao extends Model
{
    use HasFactory;

    protected $table = 'votacao';
    public $timestamps = false;

    protected $fillable = [
        'condominio_id',
        'titulo',
        'descricao',
        'data_inicio',
        'data_fim',
        'quorum_minimo',
        'status',
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'quorum_minimo' => 'integer',
    ];

    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    public function opcoes(): HasMany
    {
        return $this->hasMany(OpcaoVotacao::class, 'votacao_id');
    }

    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class, 'votacao_id');
    }
}