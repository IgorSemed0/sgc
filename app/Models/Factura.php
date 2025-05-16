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

protected $casts = [
            'data_vencimento' => 'datetime',
        ];
    public function unidades()
    {
        return $this->hasMany(Unidade::class, 'bloco_id');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function facturaItem()
    {
    return $this->hasMany(FacturaItem::class, 'factura_id');
    }

    public function pagamento()
    {
    return $this->hasMany(Pagamento::class, 'factura_id');
    }
}
