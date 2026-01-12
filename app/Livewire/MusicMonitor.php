<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SongHistory;

class MusicMonitor extends Component
{
    public function render()
    {
        // 1. Buscamos mais registros (ex: 30) para ter margem caso haja muitos duplicados
        $rawTracks = SongHistory::where('type', 'song')->orderBy('played_at', 'desc')->take(6)->get();

        // 2. Filtramos para manter apenas musicas únicas (baseado no titulo)
        // O unique mantém o primeiro registro encontrado (o mais recente) e descarta os outros
        $uniqueTracks = $rawTracks->unique('title');

        // 3. Pegamos a atual
        $nowPlaying = $uniqueTracks->first();

        // 4. Pegamos o histórico (pula a primeira e pega as próximas 10)
        $history = $uniqueTracks->skip(1)->take(10);

        return view('livewire.music-monitor', [
            'nowPlaying' => $nowPlaying,
            'history' => $history,
        ]);
    }
}