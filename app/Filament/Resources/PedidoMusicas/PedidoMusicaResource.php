<?php

namespace App\Filament\Resources\PedidoMusicas;

use App\Filament\Resources\PedidoMusicas\Pages\CreatePedidoMusica;
use App\Filament\Resources\PedidoMusicas\Pages\EditPedidoMusica;
use App\Filament\Resources\PedidoMusicas\Pages\ListPedidoMusicas;
use App\Filament\Resources\PedidoMusicas\Pages\ViewPedidoMusica;
use App\Filament\Resources\PedidoMusicas\Schemas\PedidoMusicaForm;
use App\Filament\Resources\PedidoMusicas\Schemas\PedidoMusicaInfolist;
use App\Filament\Resources\PedidoMusicas\Tables\PedidoMusicasTable;
use App\Models\PedidoMusica;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PedidoMusicaResource extends Resource
{
    protected static ?string $model = PedidoMusica::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Pedidos';

    public static function form(Schema $schema): Schema
    {
        return PedidoMusicaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PedidoMusicaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PedidoMusicasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPedidoMusicas::route('/'),
            'create' => CreatePedidoMusica::route('/create'),
            'view' => ViewPedidoMusica::route('/{record}'),
            'edit' => EditPedidoMusica::route('/{record}/edit'),
        ];
    }
}
