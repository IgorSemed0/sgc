<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'primeiro_nome', 
        'nomes_meio', 
        'ultimo_nome', 
        'email', 
        'username',
        'telefone', 
        'bi', 
        'sexo', 
        'cargo', 
        'departamento_id', 
        'condominio_id'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    // public function condominio()
    // {
    //     return $this->belongsTo(Condominio::class, 'condominio_id');
    // }

    public function morador()
    {
        return $this->hasMany(Morador::class, 'entidade_id');
    }
}