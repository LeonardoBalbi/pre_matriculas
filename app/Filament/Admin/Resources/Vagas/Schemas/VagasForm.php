<?php

namespace App\Filament\Admin\Resources\Vagas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VagasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('num_edital')
                    ->required(),
                TextInput::make('titulo')
                    ->required(),
                TextInput::make('vaga_ac')
                    ->numeric(),
                TextInput::make('vaga_pcd')
                    ->numeric(),
                TextInput::make('vaga_negro')
                    ->numeric(),
                TextInput::make('vaga_indios')
                    ->numeric(),
                Select::make('status')
                    ->options([
            'publicado' => 'Publicado',
            'pausado' => 'Pausado',
            'cancelado' => 'Cancelado',
            'finalizado' => 'Finalizado',
        ])
                    ->default('publicado'),
            ]);
    }
}
