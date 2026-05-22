<?php

namespace App\Filament\Admin\Resources\TurmaTipos;

use App\Filament\Admin\Resources\TurmaTipos\Pages\CreateTurmaTipo;
use App\Filament\Admin\Resources\TurmaTipos\Pages\EditTurmaTipo;
use App\Filament\Admin\Resources\TurmaTipos\Pages\ListTurmaTipos;
use App\Filament\Admin\Resources\TurmaTipos\Schemas\TurmaTipoForm;
use App\Filament\Admin\Resources\TurmaTipos\Tables\TurmaTiposTable;
use App\Models\TurmaTipo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TurmaTipoResource extends Resource
{
    protected static ?string $model = TurmaTipo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TurmaTipoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TurmaTiposTable::configure($table);
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
            'index' => ListTurmaTipos::route('/'),
            'create' => CreateTurmaTipo::route('/create'),
            'edit' => EditTurmaTipo::route('/{record}/edit'),
        ];
    }
}
