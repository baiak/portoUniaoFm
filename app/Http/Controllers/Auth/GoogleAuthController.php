<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            
            // Procura o usuário ou cria um novo
            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->avatar,
                'password' => null, // Usuário via Google não tem senha
                // Se precisar gerar uma senha aleatória para evitar erro:
                // 'password' => bcrypt(Str::random(16)), 
            ]);
        
            Auth::login($user);
        
            return redirect()->intended('/dashboard'); // Ou para onde você quiser mandar
            
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Erro ao logar com Google.');
        }
    }
}