<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Importante para a paginação
use App\Models\SongHistory;
use App\Models\RatedSong;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HistoricoMusicas extends Component
{
    use WithPagination; // Habilita paginação sem recarregar a página

    public $date;
    public $selectedSongTitle = '';
    public $selectedSongTimes = [];

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
    }

    // Quando a data muda, reseta a paginação para a página 1
    public function updatedDate()
    {
        $this->resetPage();
        $this->selectedSongTitle = '';
        $this->selectedSongTimes = [];
    }

    public function showPlayTimes($title, $artist)
    {
        $this->selectedSongTitle = $title;
        $this->selectedSongTimes = SongHistory::where('type', 'song')
            ->whereDate('played_at', $this->date)
            ->where('title', $title)
            ->where('artist', $artist)
            ->orderBy('played_at', 'asc')
            ->get();
    }

    public function render()
    {
        $selectedDate = Carbon::parse($this->date);
        $dateFull = $selectedDate->translatedFormat('l, d \d\e F \d\e Y');

        // --- CÁLCULO DOS DESTAQUES (Considera o dia INTEIRO) ---
        
        // Buscamos todas as músicas do dia apenas para calcular os destaques
        // (Isso é leve pois selecionamos apenas titulo e artista para agrupar)
        $allDaySongs = SongHistory::where('type', 'song')
            ->whereDate('played_at', $this->date)
            ->get();

        // 1. A Mais Curtida do Dia
        $mostLiked = null;
        if ($allDaySongs->isNotEmpty()) {
            $mostLiked = RatedSong::whereIn('title', $allDaySongs->pluck('title'))
                ->orderBy('likes', 'desc')
                ->first();
        }

        // 2. As 5 Mais Repetidas do Dia
        $mostRepeated = SongHistory::where('type', 'song')
            ->whereDate('played_at', $this->date)
            ->select('title', 'artist', 'cover_url', DB::raw('count(*) as total'))
            ->groupBy('title', 'artist', 'cover_url')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // --- LISTAGEM PAGINADA (LINHA DO TEMPO) ---
        $songs = SongHistory::where('type', 'song')
            ->whereDate('played_at', $this->date)
            ->orderBy('played_at', 'desc')
            ->paginate(15); // Exibe 15 por página

        // Transformamos a coleção paginada para incluir os likes/dislikes
        $songs->getCollection()->transform(function ($song) {
            $stats = RatedSong::where('artist', $song->artist)
                ->where('title', $song->title)
                ->first();
            $song->likes = $stats->likes ?? 0;
            $song->dislikes = $stats->dislikes ?? 0;
            return $song;
        });

        return view('livewire.historico-musicas', [
            'songs' => $songs,
            'mostLiked' => $mostLiked,
            'mostRepeated' => $mostRepeated,
            'dateFull' => $dateFull
        ]);
    }
}