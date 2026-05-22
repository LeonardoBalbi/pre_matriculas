<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Turma;

class TurmaMatriculaFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    public function name()
    {
        return 'Turma';
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where(['turma_id' => $value]);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {            
        return Turma::with(['turmaTipo', 'escola'])
            ->get()
            ->mapWithKeys(function ($turma) {
                $label = ($turma->turmaTipo ? $turma->turmaTipo->tipo_descricao : 'Turma') . 
                         ' - ' . ($turma->escola ? $turma->escola->escola_nome : 'Escola') . 
                         ' (ID: ' . $turma->id . ')';
                return [$turma->id => $label];
            })
            ->toArray();
    }
}
