<?php

namespace App\Filament\Admin\Resources\Distritos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DistritoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('distrito'),
            ]);
    }
}
