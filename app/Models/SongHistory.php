<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongHistory extends Model
{
    protected $fillable = [
        'artist',
        'title',
        'played_at',
        'cover_url', // Já vamos deixar pronto para quando fizermos a capa!
    ];

    // Dica extra: O Laravel entende 'played_at' como texto por padrão.
    // Vamos dizer pra ele que isso é uma DATA, assim podemos formatar fácil no Blade.
    protected $casts = [
        'played_at' => 'datetime',
    ];
}
