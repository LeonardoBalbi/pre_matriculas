<?php

namespace App\Filament\Admin\Resources\Vagas\Pages;

use App\Filament\Admin\Resources\Vagas\VagasResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVagas extends EditRecord
{
    protected static string $resource = VagasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
