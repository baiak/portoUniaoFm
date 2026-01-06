<?php

use App\Livewire\Home;
use App\Models\PedidoMusica;
use Illuminate\Support\Facades\Route;
use App\Models\Ouvinte;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Livewire\ListaTodasNoticias;
use App\Livewire\ExibirNoticia; 

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
// Listagem de todas as notícias
Route::get('/noticias', ListaTodasNoticias::class)->name('noticias.index');

// Notícia individual (usando o slug)
Route::get('/noticia/{slug}', ExibirNoticia::class)->name('noticia.show');