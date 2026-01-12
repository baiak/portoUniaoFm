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
        // 1. Atualiza ou Cria no Catálogo de Classificação
        // Isso garante que a música exista para receber votos
        if (isset($validated['title']) && isset($validated['artist'])) {
            RatedSong::firstOrCreate(
                ['artist' => $validated['artist'], 'title' => $validated['title']],
                ['cover_url' => $validated['cover_url'] ?? null]
            );
        }

        // 4. Resposta de Sucesso
        // Retornamos JSON com status 201 (Created - Criado com sucesso)
        return response()->json([
            'status' => 'success',
            'message' => 'Música atualizada!',
            'data' => $song
        ], 201);
    }
}
