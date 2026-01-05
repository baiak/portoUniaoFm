<?php

namespace App\Filament\Resources\Anunciantes\Pages;

use App\Filament\Resources\Anunciantes\AnuncianteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAnunciante extends EditRecord
{
    protected static string $resource = AnuncianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
