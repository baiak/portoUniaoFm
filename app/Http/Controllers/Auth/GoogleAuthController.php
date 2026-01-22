<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ouvinte; // <--- MUDANÇA 1: Usar Model Ouvinte
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
            
            // MUDANÇA 2: Busca ou cria na tabela 'ouvintes'
            $ouvinte = Ouvinte::updateOrCreate([
                'email' => $googleUser->email,
            ], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                // Se o ouvinte não tiver senha (novo cadastro), gera uma aleatória para não dar erro
            ]);

            // Garante que tenha senha se for novo (caso seu banco exija)
            if (!$ouvinte->password) {
                $ouvinte->password = bcrypt(Str::random(24));
                $ouvinte->save();
            }
        
            // MUDANÇA 3: Loga especificamente no guard 'ouvinte'
            Auth::guard('ouvinte')->login($ouvinte);
        
            return redirect()->intended('/'); 
            
        } catch (\Exception $e) {
            // Se der erro, volta pra home com mensagem
            return redirect('/')->with('error', 'Erro no login Google: ' . $e->getMessage());
        }
    }
}