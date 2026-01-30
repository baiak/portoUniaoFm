<?php

namespace App\Livewire;

use App\Models\Noticia;
use Livewire\Component;

class ExibirNoticia extends Component
{
    public Noticia $noticia;

    public function mount($slug)
    {
        $this->noticia = Noticia::where('slug', $slug)->firstOrFail();
    }
    public function title(): string
    {
        return $this->noticia->titulo . ' | Clube 87 - Porto União FM 87.9';
    }

    public function render()
    {
        return view('livewire.exibir-noticia')->title($this->title());
    }
}