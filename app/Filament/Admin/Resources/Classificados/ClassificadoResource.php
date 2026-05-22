<?php

namespace App\Filament\Admin\Resources\Classificados;

use App\Filament\Admin\Resources\Classificados\Pages\CreateClassificado;
use App\Filament\Admin\Resources\Classificados\Pages\EditClassificado;
use App\Filament\Admin\Resources\Classificados\Pages\ListClassificados;
use App\Filament\Admin\Resources\Classificados\Schemas\ClassificadoForm;
use App\Filament\Admin\Resources\Classificados\Tables\ClassificadosTable;
use App\Models\Classificado;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClassificadoResource extends Resource
{
    protected static ?string $model = Classificado::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ClassificadoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassificadosTable::configure($table);
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
            'index' => ListClassificados::route('/'),
            'create' => CreateClassificado::route('/create'),
            'edit' => EditClassificado::route('/{record}/edit'),
        ];
    }
}
