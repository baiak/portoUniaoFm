<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PedidoMusica;
use Illuminate\Support\Facades\RateLimiter;

class PedidoMusicaForm extends Component
{
    public $nome, $telefone, $musica, $mensagem;

    protected $rules = [
        'nome' => 'required|min:3',
        'mensagem' => 'required|min:5',
    ];
    public function save()
    {
        // ANTI-FLOOD: Limita a 1 pedido a cada 2 minutos por IP
        $key = 'pedido-musica:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            session()->flash('error', 'Calma! Muita emoção. Tente novamente em instantes.');
            return;
        }

        $this->validate();

        PedidoMusica::create([
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'musica' => $this->musica,
            'mensagem' => $this->mensagem,
        ]);

        RateLimiter::hit($key, 120); // Registra a tentativa por 120 segundos

        $this->reset();
        session()->flash('success', 'Pedido enviado para o locutor!');
    }
    public function render()
    {
        return view('livewire.pedido-musica-form');
    }
}
