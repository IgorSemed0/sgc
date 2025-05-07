<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EspacoComum extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
         
        'nome', 
        'descricao', 
        'regras'
    ];

    // public function condominio()
    // {
    //     return $this->belongsTo(Condominio::class, 'condominio_id');
    // }
}