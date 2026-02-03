<?php

namespace App\Filament\Resources\PedidoMusicas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables;

class PedidoMusicasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')->label('Nome'),
                Tables\Columns\TextColumn::make('musica')->label('Música')->placeholder('Só recado'),
                Tables\Columns\TextColumn::make('mensagem')->limit(50),
                Tables\Columns\ToggleColumn::make('lido')->label('Atendido'),
                Tables\Columns\TextColumn::make('created_at')->label('Hora')->time(),
            ])
            ->poll('50s')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
