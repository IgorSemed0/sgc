<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaturaItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fatura_id', 
        'categoria', 
        'descricao', 
        'valor'
    ];
}
