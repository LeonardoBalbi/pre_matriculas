<?php

namespace App\Filament\Admin\Resources\Bairros\Pages;

use App\Filament\Admin\Resources\Bairros\BairroResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBairro extends EditRecord
{
    protected static string $resource = BairroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
