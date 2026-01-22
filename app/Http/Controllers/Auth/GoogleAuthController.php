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
            
            // LÓGICA IMPORTANTE:
            // Tenta encontrar pelo Google ID OU pelo E-mail para evitar duplicidade
            // se a pessoa já tiver cadastro manual.
            
            $ouvinte = Ouvinte::updateOrCreate(
                [
                    'email' => $googleUser->email, // Chave de busca (Email é único)
                ],
                [
                    'google_id' => $googleUser->id,
                    'name'      => $googleUser->name,
                    'avatar'    => $googleUser->avatar,
                    // Como a senha é obrigatória na sua tabela, geramos uma aleatória
                    // apenas se o usuário estiver sendo criado agora.
                    // O updateOrCreate não sobrescreve se passarmos uma lógica condicional, 
                    // mas aqui vamos garantir que se não tiver senha, crie uma.
                ]
            );

            // Se for um usuário novo criado pelo Google, ele não tem senha. 
            // Precisamos preencher para não dar erro no banco (se não for nullable).
            if (!$ouvinte->password) {
                $ouvinte->password = bcrypt(Str::random(24));
                $ouvinte->save();
            }
        
            // LOGA USANDO O GUARD 'OUVINTE'
            Auth::guard('ouvinte')->login($ouvinte);
        
            return redirect()->intended('/'); 
            
        } catch (\Exception $e) {
            // Log do erro para você ver o que houve (opcional)
            // \Log::error($e->getMessage());
            
            return redirect('/')->with('error', 'Erro ao logar: ' . $e->getMessage());
        }
    }
}