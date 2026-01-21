<?php

namespace App\Filament\Resources\Ouvintes\Pages;

use App\Filament\Resources\Ouvintes\OuvinteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOuvintes extends ListRecords
{
    protected static string $resource = OuvinteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
