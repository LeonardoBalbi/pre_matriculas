<?php

namespace App\Filament\Admin\Resources\Matriculas;

use App\Filament\Admin\Resources\Matriculas\Pages\CreateMatricula;
use App\Filament\Admin\Resources\Matriculas\Pages\EditMatricula;
use App\Filament\Admin\Resources\Matriculas\Pages\ListMatriculas;
use App\Filament\Admin\Resources\Matriculas\Pages\ViewMatricula;
use App\Filament\Admin\Resources\Matriculas\Schemas\MatriculaForm;
use App\Filament\Admin\Resources\Matriculas\Schemas\MatriculaInfolist;
use App\Filament\Admin\Resources\Matriculas\Tables\MatriculasTable;
use App\Models\Matricula;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MatriculaResource extends Resource
{
    protected static ?string $model = Matricula::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nome_candidato';

    protected static ?string $navigationLabel = 'Matrículas';

    protected static ?string $modelLabel = 'matrícula';

    protected static ?string $pluralModelLabel = 'matrículas';

    public static function form(Schema $schema): Schema
    {
        return MatriculaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MatriculaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MatriculasTable::configure($table);
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
            'index' => ListMatriculas::route('/'),
            'create' => CreateMatricula::route('/create'),
            'view' => ViewMatricula::route('/{record}'),
            'edit' => EditMatricula::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
