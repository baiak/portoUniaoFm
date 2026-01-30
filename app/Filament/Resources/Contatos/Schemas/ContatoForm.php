<?php

namespace App\Filament\Resources\Contatos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContatoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('assunto')
                    ->default(null),
                Textarea::make('mensagem')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('lida')
                    ->required(),
            ]);
    }
}
