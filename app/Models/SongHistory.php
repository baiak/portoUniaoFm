<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongHistory extends Model
{
    protected $fillable = [
        'artist',
        'title',
        'played_at',
        'cover_url',
        'type',
    ];

    protected $casts = [
        'played_at' => 'datetime',
    ];
}
