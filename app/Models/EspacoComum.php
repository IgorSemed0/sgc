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
        'bloco_id',
        'regras'
    ];

    // public function condominio()
    // {
    //     return $this->belongsTo(Condominio::class, 'condominio_id');
    // }

    public function bloco()
    {
        return $this->belongsTo(Bloco::class, 'bloco_id');
    }
}