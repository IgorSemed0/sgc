<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acesso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entidade_id', 
        'tipo_pessoa', 
        'data_hora', 
        'tipo',
        'observacao',
    ];

    public function pessoa()
    {
        // Convert tipo_pessoa to lowercase to match case in if/else logic
        $tipoPessoa = strtolower($this->tipo_pessoa);
        
        if ($tipoPessoa === 'morador') {
            return $this->belongsTo(Morador::class, 'entidade_id');
        } elseif ($tipoPessoa === 'funcionario') {
            return $this->belongsTo(Funcionario::class, 'entidade_id');
        } elseif ($tipoPessoa === 'visitante') {
            return $this->belongsTo(Visitante::class, 'entidade_id');
        }
        
        // Instead of returning null, return a "null relation" using morphTo
        // This ensures that the relation methods are always available
        return $this->morphTo('pessoa', 'tipo_pessoa', 'entidade_id')->whereNull('id');
    }

    public function getNomeCompletoAttribute()
    {
        $pessoa = null;
        
        switch ($this->tipo_pessoa) {
            case 'morador':
                $pessoa = Morador::find($this->entidade_id);
                break;
            case 'funcionario':
                $pessoa = Funcionario::find($this->entidade_id);
                break;
            case 'visitante':
                $pessoa = Visitante::find($this->entidade_id);
                break;
        }
        
        if (!$pessoa) {
            return 'Desconhecido';
        }
        
        return trim($pessoa->primeiro_nome . ' ' . ($pessoa->nomes_meio ?? '') . ' ' . $pessoa->ultimo_nome);
    }
}