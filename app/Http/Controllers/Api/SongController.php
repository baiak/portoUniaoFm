<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SongHistory;

class SongController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validação: Garante que o Python mandou o que precisa
        // Se faltar algo, o Laravel já devolve erro automaticamente aqui.
        $validated = $request->validate([
            'artist' => 'required|string',
            'title' => 'required|string',
            'album' => 'nullable|string',
            'cover_url' => 'nullable|string',
        ]);

        // 2. Checagem de Duplicidade
        // Pega a última música gravada no banco
        $lastSong = SongHistory::latest()->first();

        // Se existir uma última música E ela for igual a que chegou agora...
        if ($lastSong && $lastSong->title === $validated['title'] && $lastSong->artist === $validated['artist']) {
            // ... retornamos status 200 (OK) mas não salvamos nada novo.
            return response()->json(['status' => 'ignored', 'message' => 'Essa música já está tocando'], 200);
        }

        // 3. Salvar no Banco
        // Se passou pela checagem, cria o registro novo.
        $song = SongHistory::create([
            'artist' => $validated['artist'],
            'title' => $validated['title'],
            'album' => $validated['album'] ?? null,
            'cover_url' => $validated['cover_url'] ?? null,
            'played_at' => now(),
        ]);

        // 4. Resposta de Sucesso
        // Retornamos JSON com status 201 (Created - Criado com sucesso)
        return response()->json([
            'status' => 'success',
            'message' => 'Música atualizada!',
            'data' => $song
        ], 201);
    }
}
