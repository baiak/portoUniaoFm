<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;


class Banner extends Model implements Sortable
{
    use SortableTrait;

    protected $fillable = [
        'titulo',
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
}
