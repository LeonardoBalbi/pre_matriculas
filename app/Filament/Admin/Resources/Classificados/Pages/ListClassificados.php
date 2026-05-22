<?php

namespace App\Filament\Admin\Resources\Classificados\Pages;

use App\Filament\Admin\Resources\Classificados\ClassificadoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClassificados extends ListRecords
{
    protected static string $resource = ClassificadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
