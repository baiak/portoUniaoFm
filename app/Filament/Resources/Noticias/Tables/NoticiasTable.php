<?php

namespace App\Filament\Resources\Noticias\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class NoticiasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagem')
                    ->label('Capa')
                    ->circular(),

                TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                ToggleColumn::make('is_published')
                    ->label('Publicada'),

                TextColumn::make('publicado_em')
                    ->label('Data Pub.')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Filtros se necessário
            ]);
         
    }
}
