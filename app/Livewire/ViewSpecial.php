<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Special;
use Livewire\Attributes\Layout;

class ViewSpecial extends Component
{
    public Special $special;

    public function mount($slug)
    {
        // Apenas busca o registro no banco
        $this->special = Special::where('slug', $slug)->firstOrFail();
    }

        // Define o Título da aba do navegador dinamicamente
    public function rendering($view, $data)
    {
        return $view->title($this->special->title);
    }

    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.view-special');
    }
}