<?php

namespace App\Filament\Admin\Resources\Turmas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TurmasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('escola.escola_nome')
                    ->label('Escola')
                    ->sortable(),
                TextColumn::make('turmaTipo.tipo_descricao')
                    ->label('Tipo de Turma')
                    ->sortable(),
                TextColumn::make('turma_descricao')
                    ->label('Descrição')
                    ->searchable(),
                TextColumn::make('turma_qtd_vagas')
                    ->label('Vagas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('turma_qtd_vagas_especiais')
                    ->label('Vagas Esp.')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('turma_ano_letivo')
                    ->label('Ano Letivo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('turma_status')
                    ->label('Status')
                    ->badge(),
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
