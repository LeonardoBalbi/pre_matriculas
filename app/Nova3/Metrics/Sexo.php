<?php

namespace App\Nova\Metrics;

use App\Models\Matricula;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class Sexo extends Partition
{
    public $name = 'Pré-Matricula: Sexo Predominante';
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Matricula::class, 'sexo')->colors([
            'feminino' => '#f82d97',
            'masculino' => '#0000FF',
            'outros' => '#FF0000',
        ]);
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'sexo';
    }
}
