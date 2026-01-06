<?php

namespace App\Filament\Resources\PedidoMusicas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PedidoMusicaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('telefone')
                    ->tel(),
                TextInput::make('musica'),
                Textarea::make('mensagem')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('lido')
                    ->required(),
            ]);
    }
}
