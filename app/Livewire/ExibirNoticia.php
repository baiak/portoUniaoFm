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

    public function render()
    {
        return view('livewire.exibir-noticia');
    }
}