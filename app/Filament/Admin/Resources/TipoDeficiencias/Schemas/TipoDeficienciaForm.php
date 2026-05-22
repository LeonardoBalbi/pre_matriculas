<?php

namespace App\Filament\Admin\Resources\TipoDeficiencias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TipoDeficienciaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tipo_deficiencia'),
            ]);
    }
}
