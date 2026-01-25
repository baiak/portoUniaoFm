<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class CookieConsent extends Component
{
    public bool $showBanner = false;

    public function mount()
    {
        // Verifica se o cookie 'cookie_consent' JÁ existe.
        // Se NÃO existir (null), mostramos o banner.
        if (Cookie::get('cookie_consent') === null) {
            $this->showBanner = true;
        }
    }

    public function accept()
    {
        // Cria um cookie chamado 'cookie_consent' com valor 'true'
        // Duração: 365 dias (em minutos)
        Cookie::queue('cookie_consent', true, 60 * 24 * 365);

        // Esconde o banner visualmente
        $this->showBanner = false;
    }

    public function render()
    {
        return view('livewire.cookie-consent');
    }
}