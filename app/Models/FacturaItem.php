<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacturaItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fatura_id', 
        'categoria', 
        'descricao', 
        'valor'
    ];

    public function factura()
    {
    return $this->belongsTo(Factura::class, 'factura_id');
    }
}
