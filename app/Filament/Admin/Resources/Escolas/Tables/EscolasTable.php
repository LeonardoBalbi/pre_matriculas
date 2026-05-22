<?php

namespace App\Filament\Admin\Resources\Escolas\Tables;

use App\Models\Escola;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class EscolasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('escola_foto')
                    ->label('Foto')
                    ->getStateUsing(fn (Escola $record): ?string => ($record->escola_foto && Storage::disk('public')->exists($record->escola_foto))
                        ? $record->escola_foto
                        : null)
                    ->disk('public')
                    ->visibility('public')
                    ->height(56)
                    ->width(82)
                    ->square(false)
                    ->defaultImageUrl(asset('flaro-assets/images/blog/ceim-aarao-de-moura-brito-filho.jpg'))
                    ->toggleable(),
                TextColumn::make('escola_nome')
                    ->label('Nome da Escola')
                    ->searchable(),
                TextColumn::make('escola_endereco')
                    ->label('Endereço')
                    ->searchable(),
                TextColumn::make('bairro.escola_bairro_id')
                    ->label('Bairro')
                    ->sortable(),
                TextColumn::make('distrito.distrito')
                    ->label('Distrito')
                    ->sortable(),
                TextColumn::make('escola_vagas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('escola_vagas_especiais')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('escola_ano_leitivo'),
                TextColumn::make('escola_status')
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
