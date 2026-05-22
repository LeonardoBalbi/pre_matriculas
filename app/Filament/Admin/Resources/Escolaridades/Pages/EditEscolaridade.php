<?php

namespace App\Filament\Admin\Resources\Escolaridades\Pages;

use App\Filament\Admin\Resources\Escolaridades\EscolaridadeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEscolaridade extends EditRecord
{
    protected static string $resource = EscolaridadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
