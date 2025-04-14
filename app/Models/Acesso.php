<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acesso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pessoa_id', 
        'tipo_pessoa', 
        'data_hora', 
        'tipo', 
        'dispositivo', 
        'observacao'
    ];
}
