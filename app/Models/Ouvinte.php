<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // Habilita UUID automático
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ouvinte extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'telefone',
        'password',
        'google_id',
        'avatar',
    ];

    // Esconde a senha em retornos de API ou JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Configurações para ID não-incremental (UUID)
    protected $keyType = 'string';
    public $incrementing = false;

    // Encripta a senha automaticamente ao salvar
    protected $casts = [
        'password' => 'hashed',
    ];
}