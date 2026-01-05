<?php

namespace App\Filament\Resources\Anunciantes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Grid;

class AnuncianteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema(
                Section::make('Adicionar anunciante')
                    ->schema([
                        TextInput::make('nome')->required(),
                        TextInput::make('link_url')->url()->label('Link do Site'),
                        FileUpload::make('logo')
                            ->image()
                            ->directory('anunciantes')
                            ->disk('public')
                            ->required(),
                        RichEditor::make('descricao')
                            ->toolbarButtons(['bold', 'italic', 'link'])
                            ->columnSpanFull(),
                        Toggle::make('ativo')->default(true),
                    ])
            );
    }
}
