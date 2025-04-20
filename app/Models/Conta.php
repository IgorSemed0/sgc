<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'condominio_id', 
        'nome', 
        'tipo', 
        'saldo'
    ];

    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }
    
    public function movimento()
    {
        return $this->hasMany(Conta::class, 'conta_id');
    }
}
