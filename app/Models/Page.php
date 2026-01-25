<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_in_menu',
        'is_in_footer',
    ];

    protected $casts = [
        'content' => 'array', // Essencial para o Filament Builder
        'is_in_menu' => 'boolean',
        'is_in_footer' => 'boolean',
    ];
}
