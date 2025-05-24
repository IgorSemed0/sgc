<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'votacao_id', 
        'user_id', 
        'opcao_id', 
        'data_hora', 
        'hash_voto'
    ];

    public function votacao()
    {
        return $this->belongsTo(Votacao::class, 'votacao_id');
    }

    public function opcaoVotacao()
    {
        return $this->belongsTo(OpcaoVotacao::class, 'opcao_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}