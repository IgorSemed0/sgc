<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComentarioChat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id', 
        'morador_id', 
        'conteudo', 
        'data_comentario'
    ];
    public function post_id()
    {
        return $this->belongsTo(PostChat::class, 'post_id');
    }  
    public function morador()
    {
        return $this->belongsTo(Morador::class, 'morador_id');
    }
}
