<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Banner;
use App\Models\Anunciante;

class Home extends Component
{
    public function render()
    { 
        $banners = Banner::visiveis()->get();
        $anunciantes = Anunciante::visiveis()->get();

        return view('livewire.home', compact('banners', 'anunciantes'));
    }
}
