<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'condominio_id', 
        'autor_id', 
        'tipo_autor', 
        'titulo', 
        'conteudo', 
        'data_publicacao'
    ];

    public function chatComentario()
    {
        return $this->hasMany(ChatComentario::class, 'post_id');
    }

    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'condominio_id');
    }

}
