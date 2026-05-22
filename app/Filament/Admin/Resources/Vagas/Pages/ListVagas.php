<?php

namespace App\Filament\Admin\Resources\Vagas\Pages;

use App\Filament\Admin\Resources\Vagas\VagasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVagas extends ListRecords
{
    protected static string $resource = VagasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
