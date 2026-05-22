<?php

namespace App\Filament\Admin\Resources\TurmaTipos\Pages;

use App\Filament\Admin\Resources\TurmaTipos\TurmaTipoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTurmaTipos extends ListRecords
{
    protected static string $resource = TurmaTipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
