<?php

namespace App\Livewire;

use App\Models\Page;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class ShowPage extends Component
{
    public Page $page;

    // O Livewire injeta o valor da rota /{slug} aqui automaticamente
    public function mount($slug)
    {
        // Busca a página ou 404
        $this->page = Page::where('slug', $slug)->firstOrFail();
    }

    // Define o Título da aba do navegador dinamicamente
    public function rendering($view, $data)
    {
        return $view->title($this->page->title);
    }

    // Define qual layout usar (padrão geralmente é components.layouts.app)
    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.show-page');
    }
}
