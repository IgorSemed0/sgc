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
        'data_entrada', 
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
                $pessoa = $this->belongsTo(Morador::class, 'entidade_id')->first();
                break;
            case 'funcionario':
                $pessoa = $this->belongsTo(Funcionario::class, 'entidade_id')->first();
                break;
            case 'visitante':
                $pessoa = $this->belongsTo(Visitante::class, 'entidade_id')->first();
                break;
        }
        
        if (!$pessoa) {
            return 'Desconhecido';
        }
        
        return trim($pessoa->primeiro_nome . ' ' . ($pessoa->nomes_meio ?? '') . ' ' . $pessoa->ultimo_nome);
    }
}