<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'votacao_id', 
        'morador_id', 
        'opcao_id', 
        'data_hora', 
        'hash_voto'
    ];
}