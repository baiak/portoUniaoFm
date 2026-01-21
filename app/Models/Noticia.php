<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Noticia extends Model
{
    use HasUuids;

    protected $fillable = ['titulo', 'slug', 'conteudo', 'imagem', 'is_published', 'publicado_em'];

    // Gera o slug automaticamente ao criar a notícia
    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($noticia) => $noticia->slug = Str::slug($noticia->titulo));
    }
    protected $casts = [
        'publicado_em' => 'datetime',
        'is_published' => 'boolean',
    ];
}
