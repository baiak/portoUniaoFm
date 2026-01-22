<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Visual do Banner')
                ->schema([
                    FileUpload::make('imagem_path')
                        ->label('Imagem do Banner')
                        ->image()
                        ->directory('banners')
                        ->imageEditor()
                        ->disk('public')
                        
                        ->visibility('public')
                        ->required(),

                    TextInput::make('titulo')
                        ->label('Título'),
                    RichEditor::make('descricao')
                        ->label('Descrição')
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'link',
                            'bulletList',
                            'redo',
                            'undo',
                        ]),
                    TextInput::make('link_url')
                        ->label('URL')
                        ->url(),
                ])
        ]);
    }
}
