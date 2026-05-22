<?php

namespace App\Filament\Admin\Resources\StatusMatriculas\Pages;

use App\Filament\Admin\Resources\StatusMatriculas\StatusMatriculaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStatusMatriculas extends ListRecords
{
    protected static string $resource = StatusMatriculaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
