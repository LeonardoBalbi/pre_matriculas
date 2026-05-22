<?php

namespace App\Nova\Metrics;

use App\Models\Candidato;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class Candidatos extends Value
{
    public $name = 'Ampla concorrência';
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Candidato::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => __('30 Dias'),
            60 => __('60 Dias'),
            365 => __('365 Dias'),
            'TODAY' => __('Hoje'),
            'MTD' => __('Do mês até a data'),
            'QTD' => __('Trimestre até a data'),
            'YTD' => __('No acumulado do ano'),
        ];
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
}
