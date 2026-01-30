<?php

namespace App\Filament\Resources\Contatos\Pages;

use App\Filament\Resources\Contatos\ContatoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContatos extends ListRecords
{
    protected static string $resource = ContatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
