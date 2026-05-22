<?php

namespace App\Filament\Admin\Resources\Escolaridades;

use App\Filament\Admin\Resources\Escolaridades\Pages\CreateEscolaridade;
use App\Filament\Admin\Resources\Escolaridades\Pages\EditEscolaridade;
use App\Filament\Admin\Resources\Escolaridades\Pages\ListEscolaridades;
use App\Filament\Admin\Resources\Escolaridades\Schemas\EscolaridadeForm;
use App\Filament\Admin\Resources\Escolaridades\Tables\EscolaridadesTable;
use App\Models\Escolaridade;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EscolaridadeResource extends Resource
{
    protected static ?string $model = Escolaridade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return EscolaridadeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EscolaridadesTable::configure($table);
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
            'index' => ListEscolaridades::route('/'),
            'create' => CreateEscolaridade::route('/create'),
            'edit' => EditEscolaridade::route('/{record}/edit'),
        ];
    }
}
