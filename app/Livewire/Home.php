<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Banner;

class Home extends Component
{
    public function render()
    { 
        $banners = Banner::visiveis()->get();
        return view('livewire.home', compact('banners'));
    }
}
