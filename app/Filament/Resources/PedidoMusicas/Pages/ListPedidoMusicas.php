<?php

namespace App\Filament\Resources\PedidoMusicas\Pages;

use App\Filament\Resources\PedidoMusicas\PedidoMusicaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPedidoMusicas extends ListRecords
{
    protected static string $resource = PedidoMusicaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
