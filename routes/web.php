<?php

use App\Livewire\Home;
use App\Models\PedidoMusica;
use Illuminate\Support\Facades\Route;
use App\Models\Ouvinte;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', Home::class)->name('home');
// Permite apenas 2 pedidos a cada 10 minutos por usuário logado
Route::post('/pedir-musica', [PedidoMusica::class, 'store'])
    ->middleware(['auth', 'throttle:2,10']);
Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $ouvinte = Ouvinte::updateOrCreate([
        'email' => $googleUser->email,
    ], [
        'name' => $googleUser->name,
        'google_id' => $googleUser->id,
        'avatar' => $googleUser->avatar,
    ]);

    // LOGA USANDO O GUARD 'OUVINTE'
    Auth::guard('ouvinte')->login($ouvinte);

    return redirect('/');
});