<?php

namespace App\Filament\Admin\Resources\CpfAutorizados\Pages;

use App\Filament\Admin\Resources\CpfAutorizados\CpfAutorizadoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCpfAutorizados extends ListRecords
{
    protected static string $resource = CpfAutorizadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Adicionar CPF bloqueado'),
        ];
    }
}
