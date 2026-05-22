<?php

namespace App\Filament\Admin\Resources\StatusMatriculas;

use App\Filament\Admin\Resources\StatusMatriculas\Pages\CreateStatusMatricula;
use App\Filament\Admin\Resources\StatusMatriculas\Pages\EditStatusMatricula;
use App\Filament\Admin\Resources\StatusMatriculas\Pages\ListStatusMatriculas;
use App\Filament\Admin\Resources\StatusMatriculas\Schemas\StatusMatriculaForm;
use App\Filament\Admin\Resources\StatusMatriculas\Tables\StatusMatriculasTable;
use App\Models\StatusMatricula;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StatusMatriculaResource extends Resource
{
    protected static ?string $model = StatusMatricula::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return StatusMatriculaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatusMatriculasTable::configure($table);
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
            'index' => ListStatusMatriculas::route('/'),
            'create' => CreateStatusMatricula::route('/create'),
            'edit' => EditStatusMatricula::route('/{record}/edit'),
        ];
    }
}
