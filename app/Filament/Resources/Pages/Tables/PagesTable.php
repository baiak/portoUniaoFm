<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
// Importações corretas para Ações de Tabela (Note o 'Tables\Actions')
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction; // <--- O erro estava na falta ou confusão deste aqui

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Link')
                    ->formatStateUsing(fn (string $state): string => url($state))
                    ->icon('heroicon-o-clipboard')
                    ->copyable()
                    ->copyMessage('Link copiado!')
                    ->color('info'),
                    

                IconColumn::make('is_in_menu')
                    ->label('Menu')
                    ->boolean(),

                IconColumn::make('is_in_footer')
                    ->label('Rodapé')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            // Nota: O padrão do Filament é ->actions(), mas seu gerador criou recordActions.
            // Se der erro em 'recordActions', mude para ->actions([ ... ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(), // Agora vai funcionar com o import correto
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}