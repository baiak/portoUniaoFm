<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Schemas\Schema;
// Import solicitado por você
use Filament\Schemas\Components\Grid; 

// Componentes de Formulário Padrão
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // --- Título e Slug ---
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => 
                        $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Link Permanente')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->prefix(url('/') . '/'),

                // --- Opções de Exibição (Grid solicitado) ---
                Grid::make(2)
                    ->schema([
                        Checkbox::make('is_in_menu')
                            ->label('Exibir no Menu Principal')
                            ->default(false),
                            
                        Checkbox::make('is_in_footer')
                            ->label('Exibir no Rodapé')
                            ->default(false),
                    ]),

                // --- Área de Conteúdo ---
                // Agrupando visualmente para separar do topo
                Group::make()
                    ->schema([
                        // 1. O Editor de Texto (Imagens e Formatação)
                        RichEditor::make('content')
                            ->label('Conteúdo Principal')
                            ->fileAttachmentsDirectory('pages-media') // Permite upload de imagens
                            ->fileAttachmentsVisibility('public')
                            ->toolbarButtons([
                                'attachFiles', // Botão de Imagem
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpan('full'), // Ocupa largura total

                        // 2. Campo para Google Maps / Iframes / Vídeos Youtube
                        Textarea::make('html_code')
                            ->label('Código Embed / Google Maps / HTML Extra')
                            ->rows(5)
                            ->helperText('O editor acima não aceita iframes (mapas) por segurança. Cole seus códigos de mapa ou vídeos do YouTube aqui.')
                            ->columnSpan('full'),
                    ]),
            ]);
    }
}