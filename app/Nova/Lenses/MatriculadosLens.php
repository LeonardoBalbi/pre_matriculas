<?php

namespace App\Nova\Lenses;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use App\Models\StatusMatricula;

class MatriculadosLens extends Lens
{
    public static function query(LensRequest $request, $query)
    {
        $matriculadoId = StatusMatricula::where('status_matricula', 'Matriculado')->value('id');
        if ($matriculadoId) {
            $query = $query->where('situacao_matricula', $matriculadoId);
        }
        $user = $request->user();
        if ($user && method_exists($user, 'hasRole') && $user->hasRole('colegio') && !empty($user->escola_id)) {
            $query = $query->where('escola_nome_id', $user->escola_id);
        }
        return $request->withOrdering(
            $request->withFilters($query),
            fn ($q) => $q->latest()
        );
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Status', function () {
                $status = StatusMatricula::find($this->situacao_matricula);
                return $status ? $status->status_matricula : $this->situacao_matricula;
            })->onlyOnIndex(),
            Text::make('Protocolo', 'protocolo')->sortable(),
            Text::make('Nome do Candidato', 'nome_candidato')->sortable(),
            BelongsTo::make('Escola', 'escola', \App\Nova\Escola::class)->nullable(),
            BelongsTo::make('Turma', 'turma', \App\Nova\Turma::class)->nullable(),
        ];
    }

    public function name(): string
    {
        return 'Matriculados';
    }

    public function uriKey(): string
    {
        return 'matriculados';
    }
}
