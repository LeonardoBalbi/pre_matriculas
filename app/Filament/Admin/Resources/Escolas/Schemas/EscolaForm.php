<?php

namespace App\Filament\Admin\Resources\Escolas\Schemas;

use App\Models\Bairro;
use App\Models\Distrito;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EscolaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('escola_nome')
                    ->label('Nome da Escola'),
                TextInput::make('escola_endereco')
                    ->label('Endereço'),
                TextInput::make('escola_foto')
                    ->label('Foto/URL'),
                Select::make('escola_bairro_id')
                    ->label('Bairro')
                    ->options(Bairro::all()->pluck('escola_bairro_id', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('escola_distrito_id')
                    ->label('Distrito')
                    ->options(Distrito::all()->pluck('distrito', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('escola_vagas')
                    ->numeric(),
                TextInput::make('escola_vagas_especiais')
                    ->numeric(),
                TextInput::make('escola_ano_leitivo'),
                Select::make('escola_status')
                    ->options(['ativa' => 'Ativa', 'inativa' => 'Inativa']),
            ]);
    }
}
