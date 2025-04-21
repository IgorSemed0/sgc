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
}
