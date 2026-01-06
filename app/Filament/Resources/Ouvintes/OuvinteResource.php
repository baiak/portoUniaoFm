<?php

namespace App\Filament\Resources\Ouvintes;

use App\Filament\Resources\Ouvintes\Pages\CreateOuvinte;
use App\Filament\Resources\Ouvintes\Pages\EditOuvinte;
use App\Filament\Resources\Ouvintes\Pages\ListOuvintes;
use App\Filament\Resources\Ouvintes\Pages\ViewOuvinte;
use App\Filament\Resources\Ouvintes\Schemas\OuvinteForm;
use App\Filament\Resources\Ouvintes\Schemas\OuvinteInfolist;
use App\Filament\Resources\Ouvintes\Tables\OuvintesTable;
use App\Models\Ouvinte;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OuvinteResource extends Resource
{
    protected static ?string $model = Ouvinte::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Ouvintes';

    public static function form(Schema $schema): Schema
    {
        return OuvinteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OuvinteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OuvintesTable::configure($table);
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
            'index' => ListOuvintes::route('/'),
            'create' => CreateOuvinte::route('/create'),
            'view' => ViewOuvinte::route('/{record}'),
            'edit' => EditOuvinte::route('/{record}/edit'),
        ];
    }
}
