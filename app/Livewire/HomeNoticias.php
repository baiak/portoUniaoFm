<?php

namespace App\Livewire;

use App\Models\Noticia;
use Livewire\Component;

class HomeNoticias extends Component
{
    public function render()
    {
        // Buscamos as últimas 3 ou 6 notícias para não poluir a home
        $noticias = Noticia::where('is_published', true)
            ->orderBy('publicado_em', 'desc')
            ->limit(3) 
            ->get();

        return view('livewire.home-noticias', [
            'noticias' => $noticias
        ]);
    }
}