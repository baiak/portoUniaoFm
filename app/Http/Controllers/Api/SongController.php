<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SongHistory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SongController extends Controller
{
    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Recebi uma requisição:', $request->all());
        // ---------------------------------------------------------
        // 1. Validação
        // ---------------------------------------------------------
        $validated = $request->validate([
            'artist' => 'required|string',
            'title' => 'required|string',
            'album' => 'nullable|string',
            'cover_url' => 'nullable|string',
            'type' => 'nullable|string|in:song,station',
        ]);
        // =========================================================
        // NOVO: FILTRO DE COMERCIAIS E VINHETAS
        // =========================================================
        // Lista de termos que NÃO devem ser salvos no banco
        $ignoredTerms = [
            'A Melhor Programação', 
            'Porto União FM', 
            'Comercial', 
            'Locução',
            'Desconhecido' // Opcional, se quiser ignorar desconhecidos
        ];

        if (in_array($validated['title'], $ignoredTerms) || in_array($validated['artist'], $ignoredTerms)) {
            return response()->json([
                'status' => 'ignored_commercial', 
                'message' => 'Vinheta ou comercial ignorado.'
            ], 200);
        }
        // =========================================================

        // ---------------------------------------------------------
        // 2. DEFESA 1: Race Condition (Bloqueio de 10s)
        // ---------------------------------------------------------
        // Cria uma chave única baseada no que chegou agora.
        // Se o Python mandar 2 requests iguais no mesmo segundo, o segundo bate aqui e morre.
        $songSignature = Str::slug($validated['artist'] . '_' . $validated['title']);
        $lockKey = 'song_lock_' . $songSignature;

        // Tenta criar o bloqueio. Se já existe (retorna false), aborta.
        if (!Cache::add($lockKey, true, 10)) {
            return response()->json([
                'status' => 'ignored',
                'message' => 'Race Condition: Requisição duplicada bloqueada.'
            ], 200);
        }

        // ---------------------------------------------------------
        // 3. DEFESA 2: Variação de Nome (Fuzzy Matching)
        // ---------------------------------------------------------
        $lastSong = SongHistory::latest()->first();

        if ($lastSong) {
            // Limpa as strings para comparação (remove feat, remix, pontuação)
            $cleanOldTitle = $this->normalizeString($lastSong->title);
            $cleanNewTitle = $this->normalizeString($validated['title']);
            
            $cleanOldArtist = $this->normalizeString($lastSong->artist);
            $cleanNewArtist = $this->normalizeString($validated['artist']);

            // Calcula porcentagem de similaridade
            similar_text($cleanOldTitle, $cleanNewTitle, $percentTitle);
            similar_text($cleanOldArtist, $cleanNewArtist, $percentArtist);

            // Regra: Se o artista é > 85% igual E (título > 80% igual OU um contém o outro)
            if ($percentArtist > 85 && ($percentTitle > 80 || str_contains($cleanNewTitle, $cleanOldTitle) || str_contains($cleanOldTitle, $cleanNewTitle))) {
                
                // Bônus: Se a nova versão tem capa e a antiga não, atualiza a antiga!
                if (empty($lastSong->cover_url) && !empty($validated['cover_url'])) {
                    $lastSong->update(['cover_url' => $validated['cover_url']]);
                }

                return response()->json([
                    'status' => 'ignored', 
                    'message' => 'Variação da mesma música detectada.'
                ], 200);
            }
        }

        // ---------------------------------------------------------
        // 4. Inserção (Se passou pelas duas defesas)
        // ---------------------------------------------------------
        $song = SongHistory::create([
            'artist' => $validated['artist'],
            'title' => $validated['title'],
            'album' => $validated['album'] ?? null,
            'cover_url' => $validated['cover_url'] ?? null,
            'played_at' => now(),
            'type' => $validated['type'] ?? 'song',
        ]);
        // 1. Atualiza ou Cria no Catálogo de Classificação
        // Isso garante que a música exista para receber votos
        if (isset($validated['title']) && isset($validated['artist'])) {
            RatedSong::firstOrCreate(
                ['artist' => $validated['artist'], 'title' => $validated['title']],
                ['cover_url' => $validated['cover_url'] ?? null]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Música atualizada!',
            'data' => $song
        ], 201);
    }

    /**
     * Remove sujeira do Shazam para melhorar a comparação
     */
    private function normalizeString($string)
    {
        $string = strtolower($string);
        // Lista de termos para ignorar na comparação
        $remove = [' feat.', ' feat ', ' ft.', ' ft ', ' remix', ' radio edit', ' original mix', ' live', ' version', ' remaster', ' (', ')', '[', ']'];
        $string = str_replace($remove, '', $string);
        // Remove tudo que não for letra ou número
        return preg_replace('/[^a-z0-9]/', '', $string);
    }
}