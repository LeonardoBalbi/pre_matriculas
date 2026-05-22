<?php

namespace App\Filament\Admin\Resources\Vagas;

use App\Filament\Admin\Resources\Vagas\Pages\CreateVagas;
use App\Filament\Admin\Resources\Vagas\Pages\EditVagas;
use App\Filament\Admin\Resources\Vagas\Pages\ListVagas;
use App\Filament\Admin\Resources\Vagas\Pages\ViewVagas;
use App\Filament\Admin\Resources\Vagas\Schemas\VagasForm;
use App\Filament\Admin\Resources\Vagas\Schemas\VagasInfolist;
use App\Filament\Admin\Resources\Vagas\Tables\VagasTable;
use App\Models\Vagas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VagasResource extends Resource
{
    protected static ?string $model = Vagas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'yes';

    public static function form(Schema $schema): Schema
    {
        return VagasForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VagasInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VagasTable::configure($table);
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
            'index' => ListVagas::route('/'),
            'create' => CreateVagas::route('/create'),
            'view' => ViewVagas::route('/{record}'),
            'edit' => EditVagas::route('/{record}/edit'),
        ];
    }
}
