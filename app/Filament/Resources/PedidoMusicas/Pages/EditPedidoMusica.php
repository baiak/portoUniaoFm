<?php

namespace App\Filament\Resources\PedidoMusicas\Pages;

use App\Filament\Resources\PedidoMusicas\PedidoMusicaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPedidoMusica extends EditRecord
{
    protected static string $resource = PedidoMusicaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
