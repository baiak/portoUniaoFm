<?php

namespace App\Filament\Resources\Contatos;

use App\Filament\Resources\Contatos\Pages\CreateContato;
use App\Filament\Resources\Contatos\Pages\EditContato;
use App\Filament\Resources\Contatos\Pages\ListContatos;
use App\Filament\Resources\Contatos\Pages\ViewContato;
use App\Filament\Resources\Contatos\Schemas\ContatoForm;
use App\Filament\Resources\Contatos\Schemas\ContatoInfolist;
use App\Filament\Resources\Contatos\Tables\ContatosTable;
use App\Models\Contato;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContatoResource extends Resource
{
    protected static ?string $model = Contato::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Contatos';

    public static function form(Schema $schema): Schema
    {
        return ContatoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContatoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContatosTable::configure($table);
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
            'index' => ListContatos::route('/'),
            'create' => CreateContato::route('/create'),
            'view' => ViewContato::route('/{record}'),
            'edit' => EditContato::route('/{record}/edit'),
        ];
    }
}
