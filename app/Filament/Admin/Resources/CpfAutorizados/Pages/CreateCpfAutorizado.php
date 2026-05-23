<?php

namespace App\Filament\Admin\Resources\CpfAutorizados\Pages;

use App\Filament\Admin\Resources\CpfAutorizados\CpfAutorizadoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCpfAutorizado extends CreateRecord
{
    protected static string $resource = CpfAutorizadoResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'CPF bloqueado cadastrado';
    }
}
