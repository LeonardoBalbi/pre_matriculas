<?php

namespace App\Filament\Admin\Resources\Candidatos\Pages;

use App\Filament\Admin\Resources\Candidatos\CandidatoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCandidato extends EditRecord
{
    protected static string $resource = CandidatoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
