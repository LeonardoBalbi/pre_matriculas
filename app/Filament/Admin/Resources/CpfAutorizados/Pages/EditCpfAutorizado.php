<?php

namespace App\Filament\Admin\Resources\CpfAutorizados\Pages;

use App\Filament\Admin\Resources\CpfAutorizados\CpfAutorizadoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCpfAutorizado extends EditRecord
{
    protected static string $resource = CpfAutorizadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Liberar CPF')
                ->modalHeading('Liberar CPF')
                ->modalDescription('Remove este CPF da lista de bloqueio. Depois disso, o formulario publico podera aceitar um novo cadastro com esse CPF.'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'CPF bloqueado atualizado';
    }
}
