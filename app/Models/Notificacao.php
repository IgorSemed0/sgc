<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 
        'tipo', 
        'titulo', 
        'conteudo', 
        'data_hora', 
        'lida'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
