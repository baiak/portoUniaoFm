<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoMusica extends Model
{
    protected $fillable = [
        'user_id',
        'telefone',
        'musica',
        'mensagem',
        'lido',
    ];

    public function ouvinte(): BelongsTo
    {
        // O primeiro argumento é o model alvo
        // O segundo é a coluna que você tem na tabela de pedidos (user_id)
        return $this->belongsTo(Ouvinte::class, 'user_id');
    }
}
