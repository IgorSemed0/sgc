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

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'condominio_id');
    }

    public function blocos()
    {
        return $this->hasMany(Bloco::class, 'condominio_id');
    }

    public function contas()
    {
        return $this->hasMany(Conta::class, 'condominio_id');
    }

    public function despesas()
    {
        return $this->hasMany(Despesa::class, 'condominio_id');
    }

    public function espacosComuns()
    {
        return $this->hasMany(EspacoComum::class, 'condominio_id');
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'condominio_id');
    }

    public function chatPosts()
    {
        return $this->hasMany(ChatPost::class, 'condominio_id');
    }

    public function rupes()
    {
        return $this->hasMany(Rupe::class, 'condominio_id');
    }

    public function votacoes()
    {
        return $this->hasMany(Votacao::class, 'condominio_id');
    }

    public function visitantes()
    {
        return $this->hasMany(Visitante::class, 'condominio_id');
    }

    public function unidades()
    {
        return $this->hasManyThrough(Unidade::class, Bloco::class, 'condominio_id', 'bloco_id');
    }
}