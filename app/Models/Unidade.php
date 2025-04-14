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
}
