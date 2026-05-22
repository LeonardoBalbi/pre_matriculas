<?php

namespace App\Filament\Admin\Resources\Candidatos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CandidatosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_vagas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('local')
                    ->searchable(),
                TextColumn::make('cpf')
                    ->searchable(),
                TextColumn::make('data_nasc')
                    ->date()
                    ->sortable(),
                TextColumn::make('cor_raca')
                    ->searchable(),
                TextColumn::make('nacionalidade')
                    ->searchable(),
                TextColumn::make('naturalidade')
                    ->searchable(),
                TextColumn::make('sexo')
                    ->searchable(),
                TextColumn::make('estado_civil')
                    ->searchable(),
                IconColumn::make('deficiencia')
                    ->boolean(),
                TextColumn::make('tipo_deficiencia')
                    ->searchable(),
                TextColumn::make('nome_pai')
                    ->searchable(),
                TextColumn::make('nome_mae')
                    ->searchable(),
                TextColumn::make('escolaridade')
                    ->searchable(),
                TextColumn::make('rg')
                    ->searchable(),
                TextColumn::make('rg_emissor')
                    ->searchable(),
                TextColumn::make('rg_estado')
                    ->searchable(),
                TextColumn::make('rg_data_emissao')
                    ->date()
                    ->sortable(),
                TextColumn::make('cep')
                    ->searchable(),
                TextColumn::make('endereco')
                    ->searchable(),
                TextColumn::make('numero')
                    ->searchable(),
                TextColumn::make('complemento')
                    ->searchable(),
                TextColumn::make('bairro')
                    ->searchable(),
                TextColumn::make('cidade')
                    ->searchable(),
                TextColumn::make('uf')
                    ->searchable(),
                TextColumn::make('telefone')
                    ->searchable(),
                TextColumn::make('celular')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('pontos')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
