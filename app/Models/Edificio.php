<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Edificio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome', 
        'descricao', 
        'bloco_id'
    ];
    
    public function bloco()
    {
        return $this->belongsTo(Bloco::class, 'bloco_id');
    }

    public function unidade()
    {
        return $this->hasMany(Unidade::class, 'edificio_id');
    }
}
