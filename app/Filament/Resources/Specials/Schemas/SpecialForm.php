<?php

namespace App\Filament\Resources\Specials\Schemas;


use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
//use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;



class SpecialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Adicionar especial')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título do Especial')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            // Gera o slug automaticamente
                            ->afterStateUpdated(fn (string $operation, $state, $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        FileUpload::make('cover_url')
                            ->label('Capa do Especial')
                            ->image()
                            ->disk('public')
                            ->directory('specials')
                            ->columnSpanFull(),
                    ])->columns(2),
                    // Seção 2: O Campo de Playlist HTML
                Section::make('Playlist (Low Code)')
                    ->schema([
                        Textarea::make('playlist_html')
                            ->label('Código HTML da Playlist')
                            ->helperText('Cole aqui a lista <ul> gerada pela IA contendo os links com data-vid.')
                            ->rows(20)
                            ->required(),
                    ])->columns(1),
                ]);


    }

}