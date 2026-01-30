<?php

namespace App\Filament\Resources\Contatos\Pages;

use App\Filament\Resources\Contatos\ContatoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContato extends ViewRecord
{
    protected static string $resource = ContatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
