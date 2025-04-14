<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unidade_id', 
        'referencia', 
        'data_emissao', 
        'data_vencimento', 
        'valor_total', 
        'status', 
        'observacao'
    ];
}
