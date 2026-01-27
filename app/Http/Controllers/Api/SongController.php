<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SongHistory;
use App\Models\RatedSong;

class SongController extends Controller
{
    public function store(Request $request)
    {
        // ---------------------------------------------------------
        // 1. Validação
        // ---------------------------------------------------------
        $validated = $request->validate([
            'artist'    => 'required|string',
            'title'     => 'required|string',
            'album'     => 'nullable|string',
            'cover_url' => 'nullable|string',
        ]);

        // ---------------------------------------------------------
        // 2. Busca a ÚLTIMA música salva
        // ---------------------------------------------------------
        $lastSong = SongHistory::latest('played_at')->first();

        // ---------------------------------------------------------
        // 3. Se for a MESMA música → NÃO INSERE
        // ---------------------------------------------------------
        if ($lastSong) {
            if (
                $this->normalizeString($lastSong->artist) === $this->normalizeString($validated['artist']) &&
                $this->normalizeString($lastSong->title)  === $this->normalizeString($validated['title'])
            ) {
                return response()->json([
                    'status'  => 'ignored',
                    'message' => 'Mesma música ainda tocando.'
                ], 200);
            }
        }

        // ---------------------------------------------------------
        // 4. Se mudou → INSERE
        // ---------------------------------------------------------
        $song = SongHistory::create([
            'artist'    => $validated['artist'],
            'title'     => $validated['title'],
            'album'     => $validated['album'] ?? null,
            'cover_url' => $validated['cover_url'] ?? null,
            'played_at' => now(),
            'type'      => 'song',
        ]);

        // ---------------------------------------------------------
        // 5. Garante existência para votação
        // ---------------------------------------------------------
        RatedSong::firstOrCreate(
            [
                'artist' => $song->artist,
                'title'  => $song->title,
            ],
            [
                'cover_url' => $song->cover_url,
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Nova música registrada.',
            'data'    => $song
        ], 201);
    }

    // =========================================================
    // NORMALIZA STRINGS PARA COMPARAÇÃO
    // =========================================================
    private function normalizeString(?string $string): string
    {
        if (!$string) {
            return '';
        }

        $string = mb_strtolower($string, 'UTF-8');

        $remove = [
            ' feat.', ' feat ', ' ft.', ' ft ',
            ' remix', ' radio edit', ' original mix',
            ' live', ' version', ' remaster',
            '(', ')', '[', ']', '-'
        ];

        $string = str_replace($remove, '', $string);

        return preg_replace('/[^a-z0-9]/', '', $string);

        
    }
    public function current()
    {
        // Pega o último registro inserido no histórico
        $lastSong = SongHistory::latest('played_at')->first();

        if (!$lastSong) {
            return response()->json(null, 200);
        }

        return response()->json($lastSong, 200);
    }

}
