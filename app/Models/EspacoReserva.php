<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EspacoReserva extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'espaco_id', 
        'user_id', 
        'data_reserva', 
        'hora_inicio', 
        'hora_fim', 
        'status',
        'observacao'
    ];
}
