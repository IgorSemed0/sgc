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
        'token_acesso', 
        'data_entrada', 
        'data_saida'
    ];
}
