<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo'),
                TextInput::make('imagem_path')
                    ->required(),
                TextInput::make('link_url'),
                Toggle::make('esta_ativo')
                    ->required(),
                TextInput::make('ordem')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
