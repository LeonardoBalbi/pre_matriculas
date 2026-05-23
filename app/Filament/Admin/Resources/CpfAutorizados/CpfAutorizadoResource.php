<?php

namespace App\Filament\Admin\Resources\CpfAutorizados;

use App\Filament\Admin\Resources\CpfAutorizados\Pages\CreateCpfAutorizado;
use App\Filament\Admin\Resources\CpfAutorizados\Pages\EditCpfAutorizado;
use App\Filament\Admin\Resources\CpfAutorizados\Pages\ListCpfAutorizados;
use App\Filament\Admin\Resources\CpfAutorizados\Schemas\CpfAutorizadoForm;
use App\Filament\Admin\Resources\CpfAutorizados\Tables\CpfAutorizadosTable;
use App\Models\CpfAutorizado;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CpfAutorizadoResource extends Resource
{
    protected static ?string $model = CpfAutorizado::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Liberar CPF';

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'cpf';

    protected static ?string $modelLabel = 'CPF bloqueado';

    protected static ?string $pluralModelLabel = 'CPFs bloqueados';

    public static function form(Schema $schema): Schema
    {
        return CpfAutorizadoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CpfAutorizadosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCpfAutorizados::route('/'),
            'create' => CreateCpfAutorizado::route('/create'),
            'edit' => EditCpfAutorizado::route('/{record}/edit'),
        ];
    }
}
