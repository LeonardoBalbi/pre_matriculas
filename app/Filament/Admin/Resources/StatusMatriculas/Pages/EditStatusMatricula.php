<?php

namespace App\Filament\Admin\Resources\StatusMatriculas\Pages;

use App\Filament\Admin\Resources\StatusMatriculas\StatusMatriculaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStatusMatricula extends EditRecord
{
    protected static string $resource = StatusMatriculaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
