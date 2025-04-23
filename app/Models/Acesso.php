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
        'rf_id',  
        'observacao',
    ];

    public function pessoa()
    {
        switch ($this->tipo_pessoa) {
            case 'morador':
                return $this->belongsTo(Morador::class, 'entidade_id');
            case 'funcionario':
                return $this->belongsTo(Funcionario::class, 'entidade_id');
            case 'visitante':
                return $this->belongsTo(Visitante::class, 'entidade_id');
            default:
                return null;
        }
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