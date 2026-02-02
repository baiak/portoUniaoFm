<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PedidoMusica;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PedidoMusicaForm extends Component
{
    public $nome, $telefone, $musica, $mensagem;
    public $captcha_token; // Token enviado pelo Google

    protected $rules = [
        'nome' => 'required|min:3',
        'musica' => 'required',
        'telefone' => 'nullable',
        'mensagem' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        if (auth('ouvinte')->check()) {
            $ouvinte = auth('ouvinte')->user();
            $this->nome = $ouvinte->name;
            $this->telefone = $ouvinte->telefone;
        }
    }

    public function save(Request $request)
    {
        // 1. Rate Limiter (Proteção básica por IP)
        $key = 'pedido-musica:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "Aguarde $seconds segundos para pedir outra.");
            return;
        }

        $this->validate();

        // 2. Verificação do reCAPTCHA (Apenas para deslogados)
        if (!auth('ouvinte')->check()) {
            if (!$this->captcha_token) {
                $this->addError('captcha_erro', 'Marque o campo "Não sou um robô".');
                return;
            }

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret'),
                'response' => $this->captcha_token,
                'remoteip' => $request->ip(),
            ]);

            if (!$response->json('success')) {
                $this->addError('captcha_erro', 'Falha na verificação. Tente novamente.');
                $this->dispatch('resetCaptcha');
                return;
            }
        }

        // 3. Salvar Pedido
        PedidoMusica::create([
            'user_id' => auth('ouvinte')->id() ?? null,
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'musica' => $this->musica,
            'mensagem' => $this->mensagem,
        ]);

        RateLimiter::hit($key, 180);

        // Resetar campos (exceto nome/telefone se for logado)
        $this->reset(['musica', 'mensagem', 'captcha_token']);
        
        if (!auth('ouvinte')->check()) {
            $this->dispatch('resetCaptcha');
        }
        
        session()->flash('success', 'Pedido enviado com sucesso!');
    }

    public function render()
    {
        return view('livewire.pedido-musica-form');
    }
}