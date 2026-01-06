<?php

use App\Livewire\Home;
use App\Models\PedidoMusica;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
// Permite apenas 2 pedidos a cada 10 minutos por usuário logado
Route::post('/pedir-musica', [PedidoMusica::class, 'store'])
    ->middleware(['auth', 'throttle:2,10']);