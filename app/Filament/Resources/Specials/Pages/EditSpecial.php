<?php

namespace App\Filament\Resources\Specials\Pages;

use App\Filament\Resources\Specials\SpecialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpecial extends EditRecord
{
    protected static string $resource = SpecialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
