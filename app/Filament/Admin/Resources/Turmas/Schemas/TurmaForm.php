<?php

namespace App\Filament\Admin\Resources\Turmas\Schemas;

use App\Models\Escola;
use App\Models\TurmaTipo;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TurmaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('turma_escola_id')
                    ->label('Escola')
                    ->options(Escola::all()->pluck('escola_nome', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('turma_tipo_id')
                    ->label('Tipo de Turma')
                    ->options(TurmaTipo::all()->pluck('tipo_descricao', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('turma_descricao')
                    ->label('Descrição da Turma'),
                TextInput::make('turma_qtd_vagas')
                    ->label('Vagas')
                    ->numeric(),
                TextInput::make('turma_qtd_vagas_especiais')
                    ->label('Vagas Especiais')
                    ->numeric(),
                TextInput::make('turma_ano_letivo')
                    ->label('Ano Letivo')
                    ->numeric(),
                TextInput::make('turma_idade_minima')
                    ->label('Idade Mínima (meses)')
                    ->numeric(),
                TextInput::make('turma_idade_maxima')
                    ->label('Idade Máxima (meses)')
                    ->numeric(),
                TextInput::make('turma_idade_anos')
                    ->label('Idade (anos)')
                    ->numeric(),
                Select::make('turma_status')
                    ->label('Status')
                    ->options(['ativa' => 'Ativa', 'inativa' => 'Inativa']),
            ]);
    }
}
