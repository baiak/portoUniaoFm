<?php

namespace App\Filament\Resources\Noticias\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
    
class NoticiaForm
{
public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->label('Título da Notícia')
                    ->required()
                    ->live(onBlur: true)
                    ->maxLength(255),

                FileUpload::make('imagem')
                    ->label('Thumbnail/Capa')
                    ->image()
                    ->disk('public')
                    ->directory('noticias'),

                RichEditor::make('conteudo')
                    ->label('Conteúdo')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Publicada?'),

                DateTimePicker::make('publicado_em')
                    ->label('Data de Publicação')
                    ->default(now()),
            ]);
    }
}
