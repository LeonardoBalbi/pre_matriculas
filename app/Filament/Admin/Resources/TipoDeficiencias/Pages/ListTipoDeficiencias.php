<?php

namespace App\Filament\Admin\Resources\TipoDeficiencias\Pages;

use App\Filament\Admin\Resources\TipoDeficiencias\TipoDeficienciaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTipoDeficiencias extends ListRecords
{
    protected static string $resource = TipoDeficienciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
