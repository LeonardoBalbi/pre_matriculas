<?php

namespace App\Filament\Admin\Resources\Distritos;

use App\Filament\Admin\Resources\Distritos\Pages\CreateDistrito;
use App\Filament\Admin\Resources\Distritos\Pages\EditDistrito;
use App\Filament\Admin\Resources\Distritos\Pages\ListDistritos;
use App\Filament\Admin\Resources\Distritos\Schemas\DistritoForm;
use App\Filament\Admin\Resources\Distritos\Tables\DistritosTable;
use App\Models\Distrito;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DistritoResource extends Resource
{
    protected static ?string $model = Distrito::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DistritoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DistritosTable::configure($table);
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
            'index' => ListDistritos::route('/'),
            'create' => CreateDistrito::route('/create'),
            'edit' => EditDistrito::route('/{record}/edit'),
        ];
    }
}
