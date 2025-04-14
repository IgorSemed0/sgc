<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condominio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome', 
        'endereco', 
        'bairro', 
        'cidade', 
        'estado', 
        'telefone', 
        'email'
    ];

    public function departamento()
    {
        return $this->hasMany(Departamento::class, 'condominio_id');
    }
    public function bloco()
    {
        return $this->hasMany(Bloco::class, 'condominio_id');
    }
    public function conta()
    {
        return $this->hasMany(Conta::class, 'condominio_id');
    }
}
