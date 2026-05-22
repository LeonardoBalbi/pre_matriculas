<?php

namespace App\Filament\Admin\Resources\Classificados\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClassificadoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->required(),
                Textarea::make('descricao')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
