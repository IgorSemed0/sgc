<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Morador extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'primeiro_nome',
        'nomes_meio',
        'ultimo_nome',
        'email',
        'telefone',
        'bi',
        'cedula',
        'data_nascimento',
        'sexo',
        'unidade_id',
        'tipo',
        'estado_residente',
        'dependente_de',
    ];

    public function chatComentario()
    {
        return $this->hasMany(ChatComentario::class, 'user_id');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function acesso()
    {
        return $this->hasMany(Acesso::class, 'entidade_id')->where('tipo_pessoa', 'morador');
    }

    public function inquilino()
    {
        return $this->belongsTo(Morador::class, 'dependente_de');
    }
}