<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitante extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'primeiro_nome', 
        'nomes_meio', 
        'ultimo_nome', 
        'bi', 
        'email', 
        'telefone', 
        'motivo_visita', 
        'unidade_id', 
        'condominio_id'
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    public function morador()
    {
        return $this->hasMany(Morador::class, 'entidade_id');
    }
}