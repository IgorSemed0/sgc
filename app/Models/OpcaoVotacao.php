<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpcaoVotacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'votacao_id', 
        'descricao'
    ];

    public function votacao()
    {
        return $this->belongsTo(Votacao::class, 'votacao_id');
    }

    public function votos()
    {
        return $this->hasMany(Voto::class, 'opcao_id');
    }

    // Get vote count for this option
    public function getVotosCountAttribute()
    {
        return $this->votos()->count();
    }

    // Get percentage of votes for this option
    public function getPercentualVotosAttribute()
    {
        $totalVotos = $this->votacao->voto()->count();
        
        if ($totalVotos == 0) {
            return 0;
        }
        
        return round(($this->votos_count / $totalVotos) * 100, 2);
    }
}