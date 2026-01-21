<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Storage;

class Banner extends Model implements Sortable
{
    use SortableTrait;

    protected $fillable = [
        'titulo',
        'descricao',
        'imagem_path',
        'link_url',
        'esta_ativo',
        'ordem',
    ];

    public $sortable = [
        'order_column_name' => 'ordem',
        'sort_when_creating' => true,
    ];

    protected $casts = [
    'esta_ativo' => 'boolean',
];
    public function scopeVisiveis($query)
    {
      return $query->where('esta_ativo', true)->ordered();
    }

    public function getUrlAttribute()
    {
        return $this->imagem_path ? Storage::disk('public')->url($this->imagem_path) : asset('images/placeholder.jpg');
    }
}
