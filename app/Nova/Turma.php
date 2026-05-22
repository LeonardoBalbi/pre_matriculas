<?php

namespace App\Nova;

// use Faker\Core\Number;

// use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Turma extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Turma>
     */
    public static $model = \App\Models\Turma::class;

    public static $displayInNavigation = true;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->turmaTipo ? $this->turmaTipo->tipo_descricao : 'Turma #' . $this->id;
    }

    public static $group = 'Configurações do Sistema';

    public static function label()
    {
        return 'Turmas';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'turma_escola_id', 'turma_tipo_id', 'turma_descricao', 'turma_qtd_vagas', 'turma_qtd_vagas_especiais', 'turma_ano_letivo', 'turma_idade_minima', 'turma_idade_maxima', 'turma_idade_anos', 'turma_status'
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
            id::make()->sortable(),
            text::make('Descrição', 'turma_descricao')->sortable(),
            belongsTo::make('Escola', 'escola', 'App\Nova\Escola'),
            belongsTo::make('Tipo de Turma', 'turmaTipo', 'App\Nova\TurmaTipo')
                ->nullable(),
            number::make('Qtd. Vagas', 'turma_qtd_vagas'),
            number::make('Qtd. Vagas Especiais', 'turma_qtd_vagas_especiais'),
            number::make('Ano Letivo', 'turma_ano_letivo'),
            number::make('Idade Min.', 'turma_idade_minima'),
            number::make('Indade Max.', 'turma_idade_maxima'),
            number::make('Idade Base', 'turma_idade_anos'),
            select::make('Status', 'turma_status')->options([
                'ativa' => 'Ativa',
                'inativa' => 'Inativa',
            ]),

            hasMany::make('matricula', 'matricula', 'App\Nova\Matricula')->nullable(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
     * Determine if the current user can view any resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return false;
        }

        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return true;
        }

        // Esconde "Turmas" apenas para usuários com papel "colegio"
        if ($user->hasRole('colegio')) {
            return false;
        }

        // Para todos os outros papéis, o recurso aparece normalmente
        return true;
    }

    /**
     * Garante que mesmo acessando a URL direta, o usuário "colegio"
     * não consiga listar esse recurso.
     */
    public static function authorizedToViewAny(Request $request)
    {
        return static::availableForNavigation($request);
    }
}
