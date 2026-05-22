<?php

namespace App\Filament\Admin\Resources\Classificados\Pages;

use App\Filament\Admin\Resources\Classificados\ClassificadoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClassificado extends EditRecord
{
    protected static string $resource = ClassificadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
