<?php

namespace App\Filament\Admin\Resources\TipoDeficiencias\Pages;

use App\Filament\Admin\Resources\TipoDeficiencias\TipoDeficienciaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTipoDeficiencia extends EditRecord
{
    protected static string $resource = TipoDeficienciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
