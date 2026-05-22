<?php

namespace App\Filament\Admin\Resources\Turmas\Pages;

use App\Filament\Admin\Resources\Turmas\TurmaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTurmas extends ListRecords
{
    protected static string $resource = TurmaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
