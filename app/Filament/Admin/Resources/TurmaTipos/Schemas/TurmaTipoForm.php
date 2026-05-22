<?php

namespace App\Filament\Admin\Resources\TurmaTipos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TurmaTipoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tipo_descricao'),
                Select::make('tipo_status')
                    ->options(['ativo' => 'Ativo', 'inativo' => 'Inativo']),
            ]);
    }
}
