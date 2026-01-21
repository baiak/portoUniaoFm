<?php

namespace App\Filament\Resources\Specials;

use App\Filament\Resources\Specials\Pages\CreateSpecial;
use App\Filament\Resources\Specials\Pages\EditSpecial;
use App\Filament\Resources\Specials\Pages\ListSpecials;
use App\Filament\Resources\Specials\Schemas\SpecialForm;
use App\Filament\Resources\Specials\Tables\SpecialsTable;
use App\Models\Special;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Form;


class SpecialResource extends Resource
{
    protected static ?string $model = Special::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Especiais';

    public static function form(Schema $schema): Schema
    {
        // Chama o método configure passando o $form correto
        return SpecialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpecialsTable::configure($table);
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
            'index' => ListSpecials::route('/'),
            'create' => CreateSpecial::route('/create'),
            'edit' => EditSpecial::route('/{record}/edit'),
        ];
    }
}
