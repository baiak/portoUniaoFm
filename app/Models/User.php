<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser; // IMPORTANTE
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /*Por padrão, no ambiente local (localhost), 
    qualquer usuário criado no banco de dados terá acesso ao painel. 
    Porém, em produção, o Filament bloqueia o acesso por segurança. 
    aqui vamos deixar isso arrumado, ou pelo menos tentar*/
    public function canAccessPanel(Panel $panel): bool
    {
        // No futuro, você pode mudar para: return $this->is_admin;
        // Por enquanto, vamos permitir apenas o seu e-mail específico
        return str_ends_with($this->email, '@gmail.com'); // Ou seu domínio
    }
}
