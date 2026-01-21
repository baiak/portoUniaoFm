<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Special;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;

class ViewSpecial extends Component
{
    public Special $special;
    public $tracks = [];
    
    // Variáveis para o Player
    public $currentEmbedUrl = null;
    public $currentTrackName = '';
    public $isPlaying = false;

    public function mount($slug)
    {
        $this->special = Special::where('slug', $slug)->firstOrFail();

        if (!empty($this->special->title)) {
            $this->fetchTracksFromLastFm($this->special->title);
        }
    }

    public function fetchTracksFromLastFm($artistName)
    {
        // Cache de 12 horas
        $this->tracks = Cache::remember("special_tracks_{$this->special->id}_v4", 43200, function () use ($artistName) {
            $apiKey = env('LASTFM_API_KEY');
            $response = Http::get('http://ws.audioscrobbler.com/2.0/', [
                'method' => 'artist.gettoptracks', 'artist' => $artistName, 'api_key' => $apiKey, 'format' => 'json', 'limit' => 15, 'autocorrect' => 1
            ]);
            return $response->json()['toptracks']['track'] ?? [];
        });
    }

    // --- NOVA FUNÇÃO: DEEZER (Sem API Key) ---
    public function playDeezer($trackName, $artistName)
    {
        $this->currentTrackName = $trackName;
        $this->isPlaying = true; 

        // Cache para não ficar batendo na API do Deezer toda hora
        $cacheKey = 'deezer_id_' . md5($artistName . $trackName);
        
        $deezerId = Cache::remember($cacheKey, 86400, function () use ($trackName, $artistName) {
            
            // A API do Deezer é aberta! Não precisa de chave.
            $response = Http::get('https://api.deezer.com/search', [
                'q' => 'artist:"' . $artistName . '" track:"' . $trackName . '"',
                'limit' => 1
            ]);

            if ($response->successful()) {
                return $response->json()['data'][0]['id'] ?? null;
            }

            return null;
        });

        if ($deezerId) {
            // Monta a URL do Widget do Deezer
            // theme=dark deixa o player preto
            $this->currentEmbedUrl = "https://widget.deezer.com/widget/dark/track/{$deezerId}";
        } else {
            $this->currentEmbedUrl = 'not_found';
        }
    }

    public function closePlayer()
    {
        $this->isPlaying = false;
        $this->currentEmbedUrl = null;
    }

    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.view-special');
    }
}