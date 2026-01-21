<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SongHistory;
use App\Models\RadioSetting; // Importando o model

class RadioPlayer extends Component
{
    public function render()
    {
        // Pega as configurações da rádio (Logo, Nome, Streaming)
        // O cache aqui seria bem-vindo em produção, mas vamos direto ao banco por enquanto
        $settings = RadioSetting::first();

        // Pega a música atual
        $currentSong = SongHistory::orderBy('played_at', 'desc')->first();

        return view('livewire.radio-player', [
            'settings' => $settings,
            'currentSong' => $currentSong
        ]);
    }
}