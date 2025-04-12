<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\MorphMany; // For polymorphic relations

    class Visitante extends Model
    {
        use HasFactory;

        protected $table = 'visitante';
        public $timestamps = false;

        protected $fillable = [
            'primeiro_nome',
            'nomes_meio',
            'ultimo_nome',
            'documento',
            'email',
            'telefone',
            'motivo_visita',
            'unidade_id',
            'data_entrada',
            'data_saida',
            'token_acesso',
        ];

        protected $casts = [
            'data_entrada' => 'datetime',
            'data_saida' => 'datetime',
        ];

        // Relationships
        public function unidade(): BelongsTo
        {
            return $this->belongsTo(Unidade::class, 'unidade_id');
        }

        // Polymorphic Relationship
        public function acessos(): MorphMany
        {
             // Assumes 'tipo_pessoa' column stores 'App\Models\Visitante' or similar
            return $this->morphMany(Acesso::class, 'pessoa', 'tipo_pessoa', 'pessoa_id');
        }
    }