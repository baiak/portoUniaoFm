<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Anunciante extends Model implements Sortable
{
    use SortableTrait;

    protected $fillable = ['nome', 'logo', 'descricao', 'link_url', 'ordem', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public $sortable = [
        'order_column_name' => 'ordem',
        'sort_when_creating' => true,
    ];

    // Acessório para a URL da Logo
    public function getUrlAttribute()
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : asset('images/placeholder-logo.jpg');
    }
    public function scopeVisiveis($query)
    {
        return $query->where('ativo', true)->ordered();
    }
}
