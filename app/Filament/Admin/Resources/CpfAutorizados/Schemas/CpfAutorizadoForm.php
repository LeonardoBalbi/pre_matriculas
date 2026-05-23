<?php

namespace App\Filament\Admin\Resources\CpfAutorizados\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CpfAutorizadoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cpf')
                    ->label('CPF')
                    ->required()
                    ->maxLength(14)
                    ->rule('digits:11')
                    ->unique(ignoreRecord: true)
                    ->formatStateUsing(fn (?string $state): ?string => self::formatCpf($state))
                    ->mutateStateForValidationUsing(fn (?string $state): ?string => self::normalizeCpf($state))
                    ->dehydrateStateUsing(fn (?string $state): ?string => self::normalizeCpf($state))
                    ->helperText('CPFs nesta lista ficam bloqueados para novo cadastro duplicado. Para liberar, remova o registro.'),
                Textarea::make('motivo')
                    ->label('Origem / motivo')
                    ->rows(4)
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }

    protected static function normalizeCpf(?string $cpf): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $cpf);

        return $digits ?: null;
    }

    protected static function formatCpf(?string $cpf): ?string
    {
        $digits = self::normalizeCpf($cpf);

        if (! $digits || strlen($digits) !== 11) {
            return $cpf;
        }

        return substr($digits, 0, 3) . '.' .
            substr($digits, 3, 3) . '.' .
            substr($digits, 6, 3) . '-' .
            substr($digits, 9, 2);
    }
}
