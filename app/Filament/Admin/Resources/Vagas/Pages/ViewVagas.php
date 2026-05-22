<?php

namespace App\Filament\Admin\Resources\Vagas\Pages;

use App\Filament\Admin\Resources\Vagas\VagasResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVagas extends ViewRecord
{
    protected static string $resource = VagasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
