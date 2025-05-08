<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Votacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo', 
        'descricao', 
        'data_inicio', 
        'data_fim', 
        'quorum_minimo', 
        'status'
    ];

    // public function condominio()
    // {
    //     return $this->belongsTo(Condominio::class, 'condominio_id');
    // }

    public function voto()
    {
    return $this->hasMany(Voto::class, 'votacao_id');
    }

    public function opcaoVotacaos()
    {
        return $this->hasMany(OpcaoVotacao::class, 'votacao_id');
    }
}
