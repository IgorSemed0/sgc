<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Morador extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'primeiro_nome', 
        'nomes_meio', 
        'ultimo_nome', 
        'email', 
        'username', 
        'telefone', 
        'bi', 
        'data_nascimento', 
        'sexo', 
        'unidade_id', 
        'tipo'
    ];

    public function ComentarioChat()
    {
        return $this->hasMany(ComentarioChat::class, 'user_id');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }
}
