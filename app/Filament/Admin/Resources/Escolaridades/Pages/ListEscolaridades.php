<?php

namespace App\Filament\Admin\Resources\Escolaridades\Pages;

use App\Filament\Admin\Resources\Escolaridades\EscolaridadeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEscolaridades extends ListRecords
{
    protected static string $resource = EscolaridadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
