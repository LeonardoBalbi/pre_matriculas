<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Timothyasp\Badge\Badge;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\StatusMatricula;

class Matriculados extends Resource
{
    public static $model = \App\Models\Matricula::class;
    public static $displayInNavigation = false;

    public static function label()
    {
        return 'Matriculados';
    }

    public static $title = 'nome_candidato';

    public static $search = [
        'id',
        'protocolo',
        'nome_candidato',
    ];

    public function fields(NovaRequest $request)
    {
        $statusCollection = StatusMatricula::all();
        $allStatusOptions = $statusCollection->pluck('status_matricula', 'id')->all();

        return [
            ID::make()->sortable()->readonly(),

            Text::make('Status', function () use ($allStatusOptions) {
                return $allStatusOptions[$this->situacao_matricula] ?? $this->situacao_matricula;
            })->onlyOnIndex(),

            Text::make('Protocolo', 'protocolo')->sortable()->rules('required'),
            
            Text::make('CPF', 'cpf_candidato')->sortable()->rules('required'),

            Text::make('Nome do Candidato', 'nome_candidato')->sortable()->rules('required'),

            BelongsTo::make('Escola', 'escola', Escola::class)->nullable(),

                       Badge::make('Turma', 'turma_especie')
            ->options([

                'INFANTIL 1' => 'INFANTIL 1',
                'INFANTIL 2' => 'INFANTIL 2',
                'INFANTIL 3' => 'INFANTIL 3',
                'Não atribuída' => 'Não atribuída',
            ])
            ->colors([
                'BERÇÁRIO' => 'blue',
                'BERÇÁRIO A' => 'blue',
                'INFANTIL 1' => 'cyan',
                'BERÇÁRIO B' => 'cyan',
                'INFANTIL 2' => 'green',
                'Nível 1' => 'green',
                'INFANTIL 3' => 'orange',
                'Nível 2' => 'orange',
                'Não atribuída' => 'gray',
            ])
            ->showOnIndex()
            ->showOnDetail()
            ->showOnCreating()
            ->showOnUpdating(),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        $user = $request->user();
        $matriculadoId = StatusMatricula::where('status_matricula', 'Matriculado')->value('id');

        if ($matriculadoId) {
            $query = $query->where('situacao_matricula', $matriculadoId);
        }

        if ($user && method_exists($user, 'hasRole') && $user->hasRole('colegio') && !empty($user->escola_id)) {
            $query = $query->where('escola_nome_id', $user->escola_id);
        }

        return $query;
    }
}
