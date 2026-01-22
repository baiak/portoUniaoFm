<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ouvinte; 
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; // Importante para o hash da senha

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Verifica se o ouvinte já existe pelo e-mail
            $ouvinte = Ouvinte::where('email', $googleUser->email)->first();

            if ($ouvinte) {
                // Se existe, atualiza os dados do Google
                $ouvinte->update([
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);
            } else {
                // Se NÃO existe, cria com uma senha aleatória obrigatória
                $ouvinte = Ouvinte::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => Hash::make(Str::random(24)), // Senha dummy para cumprir a regra do banco
                ]);
            }
        
            // Realiza o login
            Auth::guard('ouvinte')->login($ouvinte);
        
            return redirect()->intended('/'); 
            
        } catch (\Exception $e) {
            // Dica: Use dd($e->getMessage()) aqui temporariamente se o erro persistir para ver o motivo
            return redirect('/')->with('error', 'Erro no login: ' . $e->getMessage());
        }
    }
}