<?php

namespace App\Filament\Admin\Resources\Bairros\Schemas;

use App\Models\Distrito;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BairroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('escola_bairro_id')
                    ->label('Nome do Bairro')
                    ->required(),
                TextInput::make('descricao')
                    ->label('Descrição'),
                Select::make('distrito_id')
                    ->label('Distrito')
                    ->options(Distrito::all()->pluck('distrito', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }
}
