<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Votacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'condominio_id', 
        'titulo', 
        'descricao', 
        'data_inicio', 
        'data_fim', 
        'quorum_minimo', 
        'status'
    ];
}
