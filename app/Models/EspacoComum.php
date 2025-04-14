<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EspacoComum extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'condominio_id', 
        'nome', 
        'descricao', 
        'capacidade', 
        'regras'
    ];
}