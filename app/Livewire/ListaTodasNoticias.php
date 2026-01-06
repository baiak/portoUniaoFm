<?php

namespace App\Livewire;

use App\Models\Noticia;
use Livewire\Component;
use Livewire\WithPagination;

class ListaTodasNoticias extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.lista-todas-noticias', [
            'noticias' => Noticia::where('is_published', true)
                ->orderBy('publicado_em', 'desc')
                ->paginate(9) // 9 notícias por página
        ]);
    }
}