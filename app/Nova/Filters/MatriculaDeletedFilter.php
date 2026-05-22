<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class MatriculaDeletedFilter extends Filter
{
    public $component = 'select-filter';

    public function apply(NovaRequest $request, $query, $value)
    {
        if ($value === 'only_deleted') {
            return $query->onlyTrashed();
        } elseif ($value === 'with_deleted') {
            return $query->withTrashed();
        }

        return $query;
    }

    public function name()
    {
        return 'Registros Deletados';
    }

    public function options(NovaRequest $request)
    {
        return [
            'Apenas ativos' => 'active',
            'Apenas deletados' => 'only_deleted',
            'Todos (ativos + deletados)' => 'with_deleted',
        ];
    }
}
