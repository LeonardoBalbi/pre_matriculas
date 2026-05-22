<?php

namespace App\Filament\Admin\Resources\TipoDeficiencias;

use App\Filament\Admin\Resources\TipoDeficiencias\Pages\CreateTipoDeficiencia;
use App\Filament\Admin\Resources\TipoDeficiencias\Pages\EditTipoDeficiencia;
use App\Filament\Admin\Resources\TipoDeficiencias\Pages\ListTipoDeficiencias;
use App\Filament\Admin\Resources\TipoDeficiencias\Schemas\TipoDeficienciaForm;
use App\Filament\Admin\Resources\TipoDeficiencias\Tables\TipoDeficienciasTable;
use App\Models\TipoDeficiencia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TipoDeficienciaResource extends Resource
{
    protected static ?string $model = TipoDeficiencia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TipoDeficienciaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TipoDeficienciasTable::configure($table);
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
            'index' => ListTipoDeficiencias::route('/'),
            'create' => CreateTipoDeficiencia::route('/create'),
            'edit' => EditTipoDeficiencia::route('/{record}/edit'),
        ];
    }
}
