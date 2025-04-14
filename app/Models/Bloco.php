<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bloco extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome', 
        'descricao', 
        'condominio_id'
    ];
    
    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    public function edificio()
    {
        return $this->hasMany(Edificio::class, 'edificio_id');
    }
}