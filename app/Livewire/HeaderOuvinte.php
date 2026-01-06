<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Ouvinte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HeaderOuvinte extends Component
{
    // Campos de Cadastro
    public $name, $email, $telefone, $password;
    
    // Campos de Login
    public $loginEmail, $loginPassword;

    public $showModal = false;
    public $mode = 'login'; // 'login' ou 'register'

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:ouvintes,email',
            'password' => 'required|min:6',
        ]);

        $ouvinte = Ouvinte::create([
            'name' => $this->name,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'password' => $this->password,
        ]);

        Auth::guard('ouvinte')->login($ouvinte);
        $this->showModal = false;
        return redirect()->to(request()->header('Referer')); // Atualiza a página
    }

    public function login()
    {
        $this->validate([
            'loginEmail' => 'required|email',
            'loginPassword' => 'required',
        ]);

        if (Auth::guard('ouvinte')->attempt(['email' => $this->loginEmail, 'password' => $this->loginPassword])) {
            $this->showModal = false;
            return redirect()->to(request()->header('Referer'));
        }

        add_error('loginEmail', 'Credenciais inválidas.');
    }

    public function logout()
    {
        Auth::guard('ouvinte')->logout();
        return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.header-ouvinte');
    }
}
