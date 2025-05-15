<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $fillable = [ 
        'descricao',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
