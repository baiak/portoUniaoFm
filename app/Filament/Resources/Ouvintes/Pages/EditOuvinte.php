<?php

namespace App\Filament\Resources\Ouvintes\Pages;

use App\Filament\Resources\Ouvintes\OuvinteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOuvinte extends EditRecord
{
    protected static string $resource = OuvinteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
