<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rhyltonn\VagasXpFields\VagasXpFields;


use App\Models\VagasXp;
use App\Models\VagasXpPlus;

class CandidatoXp extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\CandidatoXp>
     */
    public static $model = \App\Models\CandidatoXp::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    // public static $displayInNavigation = false;

    public static function label()
    {
        return 'Experiência do Candidato';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $displayInNavigation = true;

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


        $vagasXpOptions = VagasXp::all()->pluck('titulo', 'id')->toArray();
        $vagasXpPlusOptions = VagasXpPlus::all()->pluck('titulo', 'id')->toArray();

        return [
            ID::make()->sortable()->hideFromIndex(),

            BelongsTo::make('Candidato', 'candidato', Candidato::class)
            ->sortable()
            ->rules('required')
            ->searchable(),

            Select::make('Experiência', 'id_vagas_xp')
            ->options($vagasXpOptions)
            ->displayUsingLabels()
            ->sortable()
            ->rules('required'),


            Select::make('Resposta', 'id_vagas_xp_plus')
            ->options($vagasXpPlusOptions)
            ->displayUsingLabels()
            ->sortable()
            ->rules('required'),


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
