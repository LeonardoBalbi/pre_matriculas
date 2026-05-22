<?php

namespace App\Filament\Admin\Resources\Bairros;

use App\Filament\Admin\Resources\Bairros\Pages\CreateBairro;
use App\Filament\Admin\Resources\Bairros\Pages\EditBairro;
use App\Filament\Admin\Resources\Bairros\Pages\ListBairros;
use App\Filament\Admin\Resources\Bairros\Schemas\BairroForm;
use App\Filament\Admin\Resources\Bairros\Tables\BairrosTable;
use App\Models\Bairro;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BairroResource extends Resource
{
    protected static ?string $model = Bairro::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BairroForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BairrosTable::configure($table);
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
            'index' => ListBairros::route('/'),
            'create' => CreateBairro::route('/create'),
            'edit' => EditBairro::route('/{record}/edit'),
        ];
    }
}
