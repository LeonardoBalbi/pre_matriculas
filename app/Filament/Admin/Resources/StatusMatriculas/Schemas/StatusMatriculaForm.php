<?php

namespace App\Filament\Admin\Resources\StatusMatriculas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StatusMatriculaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('status_matricula'),
                TextInput::make('color'),
            ]);
    }
}
