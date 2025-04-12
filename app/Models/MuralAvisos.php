<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MuralAvisos extends Model
{
    use HasFactory;

    protected $table = 'mural_avisos';
    public $timestamps = false;

    protected $fillable = [
        'condominio_id',
        'titulo',
        'conteudo',
        'data_publicacao',
        'prioridade',
        'autor_id',
        'tipo_autor',
    ];

    protected $casts = [
        'data_publicacao' => 'datetime',
    ];

    // Relationships
    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    // Polymorphic Relationship
    public function autor(): MorphTo
    {
        // Laravel will look for 'autor_id' and 'tipo_autor' columns
            // The 'tipo_autor' column should store the related model class name
        // e.g., App\Models\Morador, App\Models\Funcionario
        return $this->morphTo(__FUNCTION__, 'tipo_autor', 'autor_id');
    }
}