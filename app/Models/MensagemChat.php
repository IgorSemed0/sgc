<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MensagemChat extends Model
{
    use HasFactory;

    protected $table = 'mensagem_chat';
    public $timestamps = false;

    protected $fillable = [
        'remetente_id',
        'tipo_remetente',
        'destinatario_id',
        'tipo_destinatario',
        'conteudo',
        'data_hora',
        'status',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    // Polymorphic Relationships
    public function remetente(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'tipo_remetente', 'remetente_id');
    }

    public function destinatario(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'tipo_destinatario', 'destinatario_id');
    }
}