<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Timothyasp\Badge\Badge;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

/**
 * Este resource exibe os alunos que não efetivaram matrícula
 * (status = 10) a partir da tabela matriculas.
 */
class NaoEfetivouMatricula extends Resource
{
    /**
     * Model correto
     *
     * @var class-string<\App\Models\Matricula>
     */
    public static $model = \App\Models\Matricula::class;

    public static $displayInNavigation = true;

    /**
     * Campo usado como título do resource
     *
     * @var string
     */
    public static $title = 'protocolo';

    public static $group = 'Classificados';

    /**
     * Campos pesquisáveis
     *
     * @var array
     */
    public static $search = [
        'id',
        'protocolo',
        'nome_candidato',
    ];

    public static function label()
    {
        return 'Não efetivou matrícula';
    }

    /**
     * Campos exibidos no resource
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Protocolo', 'protocolo')
                ->sortable()
                ->rules('required'),

            Text::make('Nome do Candidato', 'nome_candidato')
                ->sortable()
                ->rules('required'),

            BelongsTo::make('Escola', 'escola', Escola::class)
                ->nullable(),

            Badge::make('Turma', 'turma_especie')
                ->options([
                    'INFANTIL 1'     => 'INFANTIL 1',
                    'INFANTIL 2'     => 'INFANTIL 2',
                    'INFANTIL 3'     => 'INFANTIL 3',
                    'Não atribuída'  => 'Não atribuída',
                ])
                ->colors([
                    'BERÇÁRIO'       => 'blue',
                    'BERÇÁRIO A'     => 'blue',
                    'BERÇÁRIO B'     => 'cyan',
                    'INFANTIL 1'     => 'cyan',
                    'INFANTIL 2'     => 'green',
                    'INFANTIL 3'     => 'orange',
                    'Não atribuída'  => 'gray',
                ])
                ->showOnIndex()
                ->showOnDetail(),
        ];
    }

    /**
     * Filtro do index: apenas alunos que não efetivaram matrícula
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('situacao_matricula', 10);
    }

    /**
     * Controla exibição no menu
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

        if ($user->hasRole('colegio')) {
            return false;
        }

        return true;
    }

    /**
     * Bloqueia acesso direto por URL
     */
    public static function authorizedToViewAny(Request $request)
    {
        return static::availableForNavigation($request);
    }

    /**
     * Bloqueia a criação de novos registros através deste resource
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new DownloadExcel)->withHeadings()->allFields(),
        ];
    }
}
