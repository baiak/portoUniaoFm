<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PedidoMusica;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class PedidoMusicaForm extends Component
{
    public $nome, $telefone, $musica, $mensagem;
    
    // Variáveis do Captcha
    public $captcha_resposta_usuario;
    public $num1;
    public $num2;

    protected $rules = [
        'nome' => 'required|min:3',
        'musica' => 'required',
        'telefone' => 'nullable', // Telefone opcional para convidados se quiser
        'mensagem' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        // Gera o desafio matemático ao carregar
        $this->gerarCaptcha();

        if (auth('ouvinte')->check()) {
            $ouvinte = auth('ouvinte')->user();
            $this->nome = $ouvinte->name;
            $this->telefone = $ouvinte->telefone;
        }
    }

    public function gerarCaptcha()
    {
        $this->num1 = rand(1, 10);
        $this->num2 = rand(1, 9);
        $this->captcha_resposta_usuario = '';
    }

    public function save(Request $request)
    {
        // 1. Verificação de Limite de Tempo (Rate Limiter)
        // Usa o IP para bloquear spam, chave única por IP
        $key = 'pedido-musica:' . $request->ip();

        // Permite 1 pedido a cada 3 minutos (180 segundos)
        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('rate_limit', "Muitos pedidos! Aguarde $seconds segundos.");
            return;
        }

        $this->validate();

        // 2. Validação do Captcha (Apenas se NÃO estiver logado)
        if (!auth('ouvinte')->check()) {
            if ((int)$this->captcha_resposta_usuario !== ($this->num1 + $this->num2)) {
                $this->addError('captcha_erro', 'Conta incorreta! Tente novamente.');
                $this->gerarCaptcha(); // Gera um novo para evitar força bruta
                return;
            }
        }

        // 3. Salvar no Banco
        PedidoMusica::create([
            'user_id' => auth('ouvinte')->id() ?? null, // Salva NULL se for convidado
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'musica' => $this->musica,
            'mensagem' => $this->mensagem,
        ]);

        // Ativa o bloqueio de tempo por 180 segundos
        RateLimiter::hit($key, 180);

        // Limpa campos e gera novo captcha
        $this->reset(['musica', 'captcha_resposta_usuario']);
        $this->gerarCaptcha();
        
        session()->flash('success', 'Pedido enviado com sucesso!');
    }

    public function render()
    {
        return view('livewire.pedido-musica-form');
    }
}