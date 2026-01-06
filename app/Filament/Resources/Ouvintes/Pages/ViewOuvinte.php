<?php

namespace App\Filament\Resources\Ouvintes\Pages;

use App\Filament\Resources\Ouvintes\OuvinteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOuvinte extends ViewRecord
{
    protected static string $resource = OuvinteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
