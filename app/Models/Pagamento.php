<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'factura_id', 
        'data_pagamento', 
        'valor_pago', 
        'metodo_pagamento', 
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }
}
