<?php

use App\Http\Controllers\Api\SongController;
use Illuminate\Support\Facades\Route;

// Agrupamos por middleware 'auth:sanctum' para proteger.
// Só quem tem a chave (Token) entra aqui.
Route::middleware('auth:sanctum')->group(function () {
    
    // Quando alguém mandar um POST para /api/update-song...
    // ... chame o método 'store' do SongController
    Route::post('/update-song', [SongController::class, 'store']);
    Route::get('/current-song', [SongController::class, 'current']);
    
});