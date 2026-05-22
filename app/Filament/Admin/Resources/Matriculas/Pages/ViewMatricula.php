<?php

namespace App\Filament\Admin\Resources\Matriculas\Pages;

use App\Filament\Admin\Resources\Matriculas\MatriculaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMatricula extends ViewRecord
{
    protected static string $resource = MatriculaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
