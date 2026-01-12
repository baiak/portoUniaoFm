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
    public function registerVote($voteType)
    {
        // 1. Gerenciamento do Cookie (Identidade do Usuário)
        $visitorId = Cookie::get('radio_visitor_id');
        
        // Se não tiver cookie, cria um UUID novo e enfileira para salvar
        if (!$visitorId) {
            $visitorId = (string) Str::uuid();
            Cookie::queue('radio_visitor_id', $visitorId, 525600); // 1 ano de validade
        }

        // 2. Pega a música tocando AGORA
        $nowPlaying = SongHistory::where('type', 'song')->latest('played_at')->first();

        if (!$nowPlaying) return;

        // 3. Garante que ela existe na tabela de votos
        $ratedSong = RatedSong::firstOrCreate(
            ['artist' => $nowPlaying->artist, 'title' => $nowPlaying->title],
            ['cover_url' => $nowPlaying->cover_url]
        );

        // 4. Verifica se ESSE visitante já votou NESSA música
        $existingVote = SongVote::where('rated_song_id', $ratedSong->id)
                                ->where('visitor_id', $visitorId)
                                ->first();

        // --- LOGICA DE VOTO ---

        // A) Primeiro voto
        if (!$existingVote) {
            SongVote::create([
                'rated_song_id' => $ratedSong->id,
                'visitor_id' => $visitorId,
                'vote_type' => $voteType
            ]);
            
            if ($voteType == 'like') $ratedSong->increment('likes');
            else $ratedSong->increment('dislikes');
        } 
        
        // B) Troca de voto (Era Like -> Virou Dislike ou vice-versa)
        elseif ($existingVote->vote_type !== $voteType) {
            
            // Remove o antigo
            if ($existingVote->vote_type == 'like') $ratedSong->decrement('likes');
            else $ratedSong->decrement('dislikes');

            // Adiciona o novo
            if ($voteType == 'like') $ratedSong->increment('likes');
            else $ratedSong->increment('dislikes');

            // Atualiza o comprovante
            $existingVote->update(['vote_type' => $voteType]);
        }
        
        // C) Clicou no mesmo botão? Faz nada.
    }

    public function render()
    {
        // 1. Buscamos mais registros (ex: 30) para ter margem caso haja muitos duplicados
        $rawTracks = SongHistory::where('type', 'song')->orderBy('played_at', 'desc')->take(6)->get();

        // 2. Filtramos para manter apenas musicas únicas (baseado no titulo)
        // O unique mantém o primeiro registro encontrado (o mais recente) e descarta os outros
        $uniqueTracks = $rawTracks->unique('title');
        $nowPlaying = $uniqueTracks->first();
        $history = $uniqueTracks->skip(1)->take(10);

        // Verifica estado do botão para o usuário atual
        $visitorId = Cookie::get('radio_visitor_id');
        $userVote = null;

        if ($nowPlaying && $visitorId) {
            $ratedSong = RatedSong::where('artist', $nowPlaying->artist)
                                  ->where('title', $nowPlaying->title)
                                  ->first();

            if ($ratedSong) {
                $vote = SongVote::where('rated_song_id', $ratedSong->id)
                                ->where('visitor_id', $visitorId)
                                ->first();
                if ($vote) $userVote = $vote->vote_type;
            }
        }

        return view('livewire.music-monitor', [
            'nowPlaying' => $nowPlaying,
            'history' => $history,
            'userVote' => $userVote
        ]);
    }
}