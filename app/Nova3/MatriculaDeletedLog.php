<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Auth;

class MatriculaDeletedLog extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MatriculaDeletedLog::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'matricula_id', 'deleted_by_name', 'motivo_exclusao',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Logs de Exclusão de Matrículas';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Log de Exclusão de Matrícula';
    }

    /**
     * Determine if the current user can view any resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToViewAny(Request $request)
    {
        return Auth::user() && Auth::user()->isSuperAdmin();
    }

    /**
     * Determine if the current user can view the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToView(Request $request)
    {
        return Auth::user() && Auth::user()->isSuperAdmin();
    }

    /**
     * Determine if the current user can create new resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
    {
        return false; // Logs não devem ser criados manualmente
    }

    /**
     * Determine if the current user can update the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
    {
        return false; // Logs não devem ser editados
    }

    /**
     * Determine if the current user can delete the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        return false; // Logs não devem ser excluídos
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('ID da Matrícula', 'matricula_id')
                ->sortable(),

            Text::make('Protocolo', function () {
                $dados = $this->dados_matricula;
                return $dados['protocolo'] ?? 'N/A';
            }),

            Text::make('Nome do Candidato', function () {
                $dados = $this->dados_matricula;
                return $dados['nome_candidato'] ?? 'N/A';
            }),

            BelongsTo::make('Excluído por', 'deletedBy', 'App\Nova\User')
                ->nullable(),

            Text::make('Nome do Usuário', 'deleted_by_name')
                ->hideFromIndex(),

            DateTime::make('Data de Exclusão', 'created_at')
                ->displayUsing(function ($value) {
                    return $value ? $value->format('d/m/Y H:i:s') : null;
                })
                ->sortable(),

            Text::make('Motivo da Exclusão', 'motivo_exclusao')
                ->hideFromIndex(),

            Code::make('Dados da Matrícula', 'dados_matricula')
                ->json()
                ->hideFromIndex(),
        ];
    }
}
