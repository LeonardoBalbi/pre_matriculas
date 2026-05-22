<?php

namespace App\Filament\Admin\Resources\Candidatos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CandidatoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_vagas')
                    ->numeric(),
                TextInput::make('nome')
                    ->required(),
                TextInput::make('local')
                    ->required(),
                TextInput::make('cpf'),
                DatePicker::make('data_nasc'),
                TextInput::make('cor_raca'),
                TextInput::make('nacionalidade'),
                TextInput::make('naturalidade'),
                TextInput::make('sexo'),
                TextInput::make('estado_civil'),
                Toggle::make('deficiencia')
                    ->required(),
                TextInput::make('tipo_deficiencia'),
                TextInput::make('nome_pai'),
                TextInput::make('nome_mae'),
                TextInput::make('escolaridade'),
                TextInput::make('rg'),
                TextInput::make('rg_emissor'),
                TextInput::make('rg_estado'),
                DatePicker::make('rg_data_emissao'),
                TextInput::make('cep'),
                TextInput::make('endereco'),
                TextInput::make('numero'),
                TextInput::make('complemento'),
                TextInput::make('bairro'),
                TextInput::make('cidade'),
                TextInput::make('uf'),
                TextInput::make('telefone')
                    ->tel(),
                TextInput::make('celular'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('pontos')
                    ->numeric(),
                TextInput::make('status')
                    ->default('Em análise'),
            ]);
    }
}
