<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'conta_id', 
        'tipo', 
        'valor', 
        'descricao', 
        'data_movimento'
    ];

    public function conta()
    {
        return $this->belongsTo(Conta::class, 'conta_id');
    }
}
