<?php

namespace App\Filament\Admin\Resources\Matriculas\Pages;

use App\Filament\Admin\Resources\Matriculas\MatriculaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMatriculas extends ListRecords
{
    protected static string $resource = MatriculaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
