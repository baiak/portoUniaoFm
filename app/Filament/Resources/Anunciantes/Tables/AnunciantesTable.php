<?php

namespace App\Filament\Resources\Anunciantes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;

class AnunciantesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('ordem')
            ->defaultSort('ordem', 'asc')
            ->columns([
                ImageColumn::make('logo')->disk('public')->size(50),
                TextColumn::make('nome')->searchable(),
                ToggleColumn::make('ativo'),
                TextColumn::make('ordem')->sortable(),
            ])
            ->filters([
                TernaryFilter::make('esta_ativo')
                    ->label('Status de Exibição')
                    ->placeholder('Todos')
                    ->trueLabel('Apenas Ativos')
                    ->falseLabel('Apenas Inativos')
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
