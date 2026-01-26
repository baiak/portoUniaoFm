<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SongHistory;
use App\Models\RatedSong;
use App\Models\SongVote;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class MusicMonitor extends Component
{
    /**
     * Registra o voto. Se $songId for nulo, assume a música atual.
     */
    public function registerVote($voteType, $songId = null)
    {
        $visitorId = Cookie::get('radio_visitor_id');
        
        if (!$visitorId) {
            $visitorId = (string) Str::uuid();
            Cookie::queue('radio_visitor_id', $visitorId, 525600);
        }

        // Busca a música específica ou a última que tocou
        $targetSong = $songId 
            ? SongHistory::find($songId) 
            : SongHistory::where('type', 'song')->latest('played_at')->first();

        if (!$targetSong) return;

        $ratedSong = RatedSong::firstOrCreate(
            ['artist' => $targetSong->artist, 'title' => $targetSong->title],
            ['cover_url' => $targetSong->cover_url]
        );

        $existingVote = SongVote::where('rated_song_id', $ratedSong->id)
                                ->where('visitor_id', $visitorId)
                                ->first();

        if (!$existingVote) {
            SongVote::create([
                'rated_song_id' => $ratedSong->id,
                'visitor_id' => $visitorId,
                'vote_type' => $voteType
            ]);
            
            $voteType == 'like' ? $ratedSong->increment('likes') : $ratedSong->increment('dislikes');
        } 
        elseif ($existingVote->vote_type !== $voteType) {
            // Troca de voto
            $existingVote->vote_type == 'like' ? $ratedSong->decrement('likes') : $ratedSong->decrement('dislikes');
            $voteType == 'like' ? $ratedSong->increment('likes') : $ratedSong->increment('dislikes');
            $existingVote->update(['vote_type' => $voteType]);
        }
    }

    public function render()
    {
        $visitorId = Cookie::get('radio_visitor_id');

        // Buscamos as últimas músicas para montar a lista
        $rawTracks = SongHistory::where('type', 'song')
            ->orderBy('played_at', 'desc')
            ->take(15)
            ->get();

        // Filtramos por combinação única de Artista + Título
        $uniqueTracks = $rawTracks->unique(fn($item) => $item->artist . $item->title);

        // Mapeamos cada música para verificar se o usuário já votou nela
        $tracksWithVotes = $uniqueTracks->map(function ($track) use ($visitorId) {
            $userVote = null;
            if ($visitorId) {
                $rated = RatedSong::where('artist', $track->artist)
                                  ->where('title', $track->title)
                                  ->first();
                if ($rated) {
                    $vote = SongVote::where('rated_song_id', $rated->id)
                                    ->where('visitor_id', $visitorId)
                                    ->first();
                    $userVote = $vote ? $vote->vote_type : null;
                }
            }
            $track->user_vote = $userVote; // Atribui o status do voto ao objeto da música
            return $track;
        });

        return view('livewire.music-monitor', [
            'nowPlaying' => $tracksWithVotes->first(),
            'history' => $tracksWithVotes->skip(1)->take(5)
        ]);
    }
}