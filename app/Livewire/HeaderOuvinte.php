<?php

namespace App\Livewire;

use App\Models\Ouvinte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class HeaderOuvinte extends Component
{
    /** Cadastro */
    public string $name = '';
    public string $email = '';
    public ?string $telefone = null;
    public string $password = '';

    /** Login */
    public string $loginEmail = '';
    public string $loginPassword = '';

    /** UI */
    public bool $showModal = false;
    public string $mode = 'login'; // login | register

    protected function rules(): array
    {
        return match ($this->mode) {
            'register' => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:ouvintes,email',
                'password' => 'required|min:6',
                'telefone' => 'nullable|string|max:20',
            ],
            default => [
                'loginEmail' => 'required|email',
                'loginPassword' => 'required|string',
            ],
        };
    }

    protected function messages(): array
    {
        return [
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ];
    }

    public function register(): void
    {
        $this->mode = 'register';
        $this->validate();

        $ouvinte = Ouvinte::create([
            'name' => $this->name,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'password' => Hash::make($this->password),
        ]);

        Auth::guard('ouvinte')->login($ouvinte);

        $this->resetForm();
        $this->closeModal();

        redirect()->back();
    }

    public function login(): void
    {
        $this->mode = 'login';
        $this->validate();

        if (! Auth::guard('ouvinte')->attempt([
            'email' => $this->loginEmail,
            'password' => $this->loginPassword,
        ])) {
            $this->addError('loginEmail', 'E-mail ou senha inválidos.');
            return;
        }

        $this->resetForm();
        $this->closeModal();

        redirect()->back();
    }

    public function logout(): void
    {
        Auth::guard('ouvinte')->logout();

        redirect()->back();
    }

    public function openModal(string $mode = 'login'): void
    {
        $this->resetErrorBag();
        $this->mode = $mode;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'name',
            'email',
            'telefone',
            'password',
            'loginEmail',
            'loginPassword',
        ]);
    }

    public function render()
    {
        return view('livewire.header-ouvinte');
    }
}
