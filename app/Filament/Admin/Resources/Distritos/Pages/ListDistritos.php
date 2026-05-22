<?php

namespace App\Filament\Admin\Resources\Distritos\Pages;

use App\Filament\Admin\Resources\Distritos\DistritoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDistritos extends ListRecords
{
    protected static string $resource = DistritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
