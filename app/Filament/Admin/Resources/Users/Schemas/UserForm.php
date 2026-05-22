<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Models\Escola;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações Básicas')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        Select::make('escola_id')
                            ->label('Escola vinculada')
                            ->options(Escola::all()->pluck('escola_nome', 'id'))
                            ->searchable()
                            ->nullable(),
                    ])->columns(2),

                Section::make('Níveis de Acesso')
                    ->description('Somente Super Administradores podem gerenciar estas opções.')
                    ->visible(fn () => auth()->user()?->isSuperAdmin())
                    ->schema([
                        Select::make('roles')
                            ->label('Funções (Roles)')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload(),
                        CheckboxList::make('permissions')
                            ->label('Permissões Diretas')
                            ->relationship('permissions', 'name')
                            ->columns(3),
                    ]),
            ]);
    }
}
