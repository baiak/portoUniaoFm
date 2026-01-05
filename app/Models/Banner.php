<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'titulo',
        'imagem_path',
        'link_url',
        'esta_ativo',
        'ordem',
    ];
}
