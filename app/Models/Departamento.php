<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome', 
        'descricao', 
        'condominio_id',
        'unidade_id'
    ];

    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

    public function funcionario()
    {
        return $this->hasMany(Funcionario::class, 'departamento_id');
    }
}
