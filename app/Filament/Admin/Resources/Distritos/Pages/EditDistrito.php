<?php

namespace App\Filament\Admin\Resources\Distritos\Pages;

use App\Filament\Admin\Resources\Distritos\DistritoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDistrito extends EditRecord
{
    protected static string $resource = DistritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
