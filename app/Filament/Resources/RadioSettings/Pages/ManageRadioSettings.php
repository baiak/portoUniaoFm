<?php

namespace App\Filament\Resources\RadioSettings\Pages;

use App\Filament\Resources\RadioSettings\RadioSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRadioSettings extends ManageRecords
{
    protected static string $resource = RadioSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
