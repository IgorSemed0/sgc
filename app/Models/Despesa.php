<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Despesa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
         
        'categoria', 
        'descricao', 
        'valor', 
        'data_despesa'
    ];

    // public function condominio()
    // {
    //     return $this->belongsTo(Condominio::class, 'condominio_id');
    // }
}
