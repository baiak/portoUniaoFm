<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoMusica extends Model
{
    protected $fillable = [
        'user_id',
        'telefone',
        'musica',
        'mensagem',
        'lido',
    ];
}
