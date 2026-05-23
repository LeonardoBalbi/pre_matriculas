<?php

namespace App\Filament\Admin\Resources\CpfAutorizados\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class CpfAutorizadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cpf')
                    ->label('CPF')
                    ->formatStateUsing(fn (?string $state): string => self::formatCpf($state))
                    ->searchable(query: function ($query, string $search): void {
                        $digits = preg_replace('/\D+/', '', $search);

                        $query->where('cpf', 'like', '%' . ($digits ?: $search) . '%');
                    })
                    ->copyable(),
                TextColumn::make('motivo')
                    ->label('Origem / motivo')
                    ->limit(70)
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Registrado por')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Bloqueado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('liberarCpf')
                    ->label('Liberar CPF')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Liberar CPF')
                    ->modalDescription('Remove este CPF da lista de bloqueio. Depois disso, o formulario publico podera aceitar um novo cadastro com esse CPF.')
                    ->action(function ($record): void {
                        $cpf = self::formatCpf($record->cpf);
                        $record->delete();

                        Notification::make()
                            ->title('CPF liberado')
                            ->body("O CPF {$cpf} foi liberado para novo cadastro.")
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('liberarCpfs')
                        ->label('Liberar selecionados')
                        ->icon('heroicon-o-lock-open')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Liberar CPFs selecionados')
                        ->modalDescription('Remove os CPFs selecionados da lista de bloqueio.')
                        ->action(function (Collection $records): void {
                            $count = $records->count();
                            $records->each->delete();

                            Notification::make()
                                ->title('CPFs liberados')
                                ->body("{$count} CPF(s) liberado(s) para novo cadastro.")
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }

    protected static function formatCpf(?string $cpf): string
    {
        $digits = preg_replace('/\D+/', '', (string) $cpf);

        if (strlen($digits) !== 11) {
            return $digits ?: '-';
        }

        return substr($digits, 0, 3) . '.' .
            substr($digits, 3, 3) . '.' .
            substr($digits, 6, 3) . '-' .
            substr($digits, 9, 2);
    }
}
