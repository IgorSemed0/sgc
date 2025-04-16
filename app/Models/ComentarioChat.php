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
        'user_id', 
        'conteudo', 
        'data_comentario'
    ];
    public function post_id()
    {
        return $this->belongsTo(PostChat::class, 'post_id');
    }  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
