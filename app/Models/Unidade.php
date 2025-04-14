<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo', 
        'numero', 
        'bloco_id', 
        'edificio_id', 
        'andar', 
        'area_m2', 
        'status'
    ];

    public function factura()
    {
        return $this->hasMany(Factura::class, 'factura_id');
    }

    public function bloco()
    {
        return $this->belongsTo(Bloco::class, 'bloco_id');
    }

    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'edificio_id');
    }

    public function morador()
    {
        return $this->hasMany(Morador::class, 'unidade_id');
    }
}
