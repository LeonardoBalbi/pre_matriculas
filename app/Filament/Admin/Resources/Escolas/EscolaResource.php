<?php

namespace App\Filament\Admin\Resources\Escolas;

use App\Filament\Admin\Resources\Escolas\Pages\CreateEscola;
use App\Filament\Admin\Resources\Escolas\Pages\EditEscola;
use App\Filament\Admin\Resources\Escolas\Pages\ListEscolas;
use App\Filament\Admin\Resources\Escolas\Schemas\EscolaForm;
use App\Filament\Admin\Resources\Escolas\Tables\EscolasTable;
use App\Models\Escola;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EscolaResource extends Resource
{
    protected static ?string $model = Escola::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return EscolaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EscolasTable::configure($table);
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
            'index' => ListEscolas::route('/'),
            'create' => CreateEscola::route('/create'),
            'edit' => EditEscola::route('/{record}/edit'),
        ];
    }
}
