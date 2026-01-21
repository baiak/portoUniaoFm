<?php

namespace App\Filament\Resources\Ouvintes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OuvinteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('telefone'),
                TextEntry::make('google_id'),
                TextEntry::make('avatar'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
