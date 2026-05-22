<?php

namespace App\Filament\Admin\Resources\TurmaTipos\Pages;

use App\Filament\Admin\Resources\TurmaTipos\TurmaTipoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTurmaTipo extends EditRecord
{
    protected static string $resource = TurmaTipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
