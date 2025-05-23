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

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'unidade_id');
    }

    public function visitantes()
    {
        return $this->hasMany(Visitante::class, 'unidade_id');
    }

    public function bloco()
    {
        return $this->belongsTo(Bloco::class, 'bloco_id');
    }

    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'edificio_id');
    }

    public function moradores()
    {
        return $this->hasMany(Morador::class, 'unidade_id');
    }

    // public function condominio()
    // {
    //     return $this->hasOneThrough(Condominio::class, Bloco::class, 'id', 'id', 'bloco_id', 'condominio_id');
    // }
}