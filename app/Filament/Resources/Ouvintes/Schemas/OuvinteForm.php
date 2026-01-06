<?php

namespace App\Filament\Resources\Ouvintes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema; // Certifique-se que este import está correto de acordo com seu projeto
use Illuminate\Support\Facades\Hash;

class OuvinteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('telefone')
                    ->label('Telefone/WhatsApp')
                    ->tel(),

                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    // Só encripta se houver valor preenchido
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    // Não sobrescreve a senha se o campo for deixado vazio na edição
                    ->dehydrated(fn ($state) => filled($state))
                    // Obrigatório apenas quando estiver criando um novo registro
                    ->required(fn (string $context): bool => $context === 'create')
                    ->placeholder('Deixe em branco para não alterar'),

                TextInput::make('google_id')
                    ->label('Google ID')
                    ->disabled(),

                TextInput::make('avatar')
                    ->label('URL do Avatar')
                    ->disabled(),
            ]);
    }
}