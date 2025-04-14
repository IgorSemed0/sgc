<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostChat extends Model
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

    public function ComentarioChat()
    {
        return $this->hasMany(ComentarioChat::class, 'post_id');
    }

    public function condominio()
    {
        return $this->belongsTo(condominio::class, 'condominio_id');
    }

}
