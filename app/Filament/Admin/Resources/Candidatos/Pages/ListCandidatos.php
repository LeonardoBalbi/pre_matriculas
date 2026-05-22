<?php

namespace App\Filament\Admin\Resources\Candidatos\Pages;

use App\Filament\Admin\Resources\Candidatos\CandidatoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCandidatos extends ListRecords
{
    protected static string $resource = CandidatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
