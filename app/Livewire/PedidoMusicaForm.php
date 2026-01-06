<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\PedidoMusica;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth; // Adicionado

class PedidoMusicaForm extends Component
{
    public $nome, $telefone, $musica, $mensagem;

    protected $rules = [
        'nome' => 'required|min:3',
        'musica' => 'required', // Adicionei musica como obrigatório
       // 'mensagem' => 'required|min:5',
    ];

    // Preenche os dados automaticamente ao carregar o componente
    public function mount()
    {
        if (auth('ouvinte')->check()) {
            $ouvinte = auth('ouvinte')->user();
            $this->nome = $ouvinte->name;
            $this->telefone = $ouvinte->telefone;
        }
    }

    public function save()
    {
        $key = 'pedido-musica:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            session()->flash('error', 'Calma! Muita emoção. Tente novamente em instantes.');
            return;
        }

        $this->validate();

        PedidoMusica::create([
            'user_id' => auth('ouvinte')->id(),
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'musica' => $this->musica,
           // 'mensagem' => $this->mensagem,
        ]);

        RateLimiter::hit($key, 120);

        // Reseta apenas música e mensagem, mantém nome/telefone se logado
        $this->reset(['musica', 'mensagem']);
        
        session()->flash('success', 'Pedido enviado para o locutor!');
    }

    public function render()
    {
        return view('livewire.pedido-musica-form');
    }
}