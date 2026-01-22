<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ouvinte; 
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
            
            // Cria ou Atualiza na tabela de OUVINTES
            $ouvinte = Ouvinte::updateOrCreate([
                'email' => $googleUser->email,
            ], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
            ]);

            // Se for novo e não tiver senha, gera uma aleatória para não dar erro no banco
            if (!$ouvinte->password) {
                $ouvinte->password = bcrypt(Str::random(24));
                $ouvinte->save();
            }
        
            // LOGA NO GUARD 'OUVINTE'
            Auth::guard('ouvinte')->login($ouvinte);
        
            return redirect()->intended('/'); 
            
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Erro no login: ' . $e->getMessage());
        }
    }
}