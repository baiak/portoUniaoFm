<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RatedSong;

class TopSongs extends Component
{
    public function render()
    {
        // Busca as 5 mais votadas, ordenando por Likes
        // Critério de desempate: quem teve voto mais recente (updated_at)
        $topSongs = RatedSong::where('likes', '>', 0)
                             ->orderBy('likes', 'desc')
                             ->orderBy('updated_at', 'desc')
                             ->take(5)
                             ->get();

        return view('livewire.top-songs', [
            'songs' => $topSongs
        ]);
    }
}