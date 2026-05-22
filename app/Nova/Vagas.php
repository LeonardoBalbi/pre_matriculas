<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Timothyasp\Badge\Badge;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\belongsTo;
use Laravel\Nova\Fields\HasMany;

class Vagas extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Vagas>
     */
    public static $model = \App\Models\Vagas::class;
    public static $displayInNavigation = true;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'titulo';

    public static function label()
    {
        return "Vagas";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

public static function availableForNavigation(Request $request)
{
    $user = $request->user();

    return !(
        $user &&
        method_exists($user, 'hasRole') &&
        (
            $user->hasRole('admin_edu') ||
            $user->hasRole('colegio')
        )
    );
}
    public static function authorizedToViewAny(Request $request)
    {
        return static::availableForNavigation($request);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {

        $status = [
            'publicado' => "Publicado",
            'pausado' => "Pausado",
            'cancelado' => "Cancelado",
            'finalizado' => "Finalizado",
        ];

        return [
            ID::make()->sortable(),

            Text::make('Numero do Edital', 'num_edital')
                ->sortable()
                ->rules('required', 'max:255'),

                Text::make('Titulo', 'titulo')
                ->sortable()->rules('required', 'max:255'),

                Number::make('Vagas Ampla Concorrência ', 'vaga_ac')
                ->max(1000),

                Number::make('Vagas PCD ', 'vaga_pcd')
                ->max(1000),

                Number::make('Vagas Negros ', 'vaga_negro')
                ->max(1000),

                Number::make('Vagas Índios ', 'vaga_negro')
                ->max(1000),

                Badge::make('Status', 'status')->options($status)
                ->colors([
                   'publicado' => '#15B750',
                   'pausado' => '#E8F615',
                   'cancelado' => '#EF2D13',
                   'finalizado' => '#08970C',
                ])->default('publicado'),


                HasMany::make('Experiência', 'vagasxp', 'App\nova\VagasXp')


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
