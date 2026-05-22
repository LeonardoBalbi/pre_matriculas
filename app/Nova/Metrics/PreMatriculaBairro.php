<?php

namespace App\Nova\Metrics;

use App\Models\Matricula;
use App\Models\Bairro;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class PreMatriculaBairro extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // Obtenha todos os IDs dos bairros das matrículas
        $bairroIds = Matricula::pluck('escola_bairro_id')->unique()->toArray();

        // Obtenha as descrições dos bairros usando a cláusula whereIn
        $bairros = Bairro::whereIn('id', $bairroIds)->pluck('escola_bairro_id', 'id');

        return $this->count($request, Matricula::class, 'escola_bairro_id')->label(function ($value) use ($bairros) {
            // Use o array $bairros para mapear o ID para a descrição correspondente
            return $bairros[$value] ?? 'Desconhecido';
        })->colors([
            '1' => '#f82d97',
            '2' => '#0000FF',
            '3' => '#FF0000',
            '4' => '#00FF00',
            '5' => '#FFFF00',
            '6' => '#00FFFF',
            '7' => '#FF00FF',
            '8' => '#C0C0C0',
            '9' => '#808080',
            '10' => '#800000',
            '11' => '#808000',
            '12' => '#008000',
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
        return 'pre-matricula-bairro';
    }
}
