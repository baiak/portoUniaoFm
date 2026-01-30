<?php

namespace App\Livewire;

use App\Models\Contato;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Title;

class ContatoForm extends Component
{
    public $nome, $email, $assunto, $mensagem, $captcha;
    
    // Simplificando as regras para o padrão do Livewire
    protected $rules = [
        'nome' => 'required|min:3',
        'email' => 'required|email',
        'mensagem' => 'required|min:10',
        'captcha' => 'required',
    ];

    public function enviar()
    {
        // 1. Valida TODOS os campos definidos em $rules de uma vez
        // Se algo estiver errado, o Livewire para aqui mesmo e mostra os erros no Blade
        $this->validate();

        // 2. Validar o token com o servidor do Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $this->captcha,
        ]);

        $captchaValido = $response->json('success');

        if ($captchaValido) {
            // 3. Só salva se o captcha for sucesso
            Contato::create([
                'nome' => $this->nome,
                'email' => $this->email,
                'assunto' => $this->assunto,
                'mensagem' => $this->mensagem,
                'lida' => false, // Garante o valor padrão
            ]);

            $this->reset();
            
            // Avisa o front-end para resetar o widget visual do reCAPTCHA
            $this->dispatch('reset-captcha');
            
            session()->flash('message', 'Formulário enviado com sucesso!');
        } else {
            // Se o Google rejeitar o token
            $this->addError('captcha', 'Falha na verificação do reCAPTCHA. Tente novamente.');
        }
    }
    #[Title('Fale conosco | Clube 87 ')]
    public function render()
    {
        return view('livewire.contato-form');
    }
}