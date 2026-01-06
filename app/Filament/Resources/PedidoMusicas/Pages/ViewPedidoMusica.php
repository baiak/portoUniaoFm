<?php

namespace App\Filament\Resources\PedidoMusicas\Pages;

use App\Filament\Resources\PedidoMusicas\PedidoMusicaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPedidoMusica extends ViewRecord
{
    protected static string $resource = PedidoMusicaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
