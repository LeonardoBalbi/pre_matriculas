<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Escola extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Escola>
     */
    public static $model = \App\Models\Escola::class;

    public static $displayInNavigation = true;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'escola_nome';

    public static $group = 'Configurações do Sistema';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','escola_nome', 'escola_distrito_id'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Nome', 'escola_nome')->nullable(),
            Text::make('Endereço', 'escola_endereco')->nullable(),
            BelongsTo::make('Bairro', 'bairro', 'App\Nova\Bairro')->nullable(),            
            BelongsTo::make('Distrito', 'distrito', 'App\Nova\Distrito')->nullable(),            
            // Number::make('Vagas', 'escola_vagas')->nullable(),
            // Number::make('Vagas Especiais', 'escola_vagas_especiais')->nullable(),
            Number::make('Ano Letivo', 'escola_ano_leitivo')->nullable(),
            Select::make('Status', 'escola_status')->options([
                'ativa' => 'Ativa',
                'inativa'=> 'Inativa',
            ]),

            // HasMany::make('Tipos de Turma', 'turmatipos', 'App\Nova\TurmaTipo'),
            BelongsToMany::make('Tipos de Turma (multi)', 'turmaTiposMulti', 'App\Nova\TurmaTipo'),
            // O campo Select do Nova não suporta múltipla seleção.
            // Para múltiplos tipos de turma, utilize o relacionamento HasMany ou BelongsToMany.
            // HasMany::make('TURMA', 'turma', 'App\Nova\Turma'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
