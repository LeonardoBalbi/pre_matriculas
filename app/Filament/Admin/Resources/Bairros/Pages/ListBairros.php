<?php

namespace App\Filament\Admin\Resources\Bairros\Pages;

use App\Filament\Admin\Resources\Bairros\BairroResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBairros extends ListRecords
{
    protected static string $resource = BairroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
