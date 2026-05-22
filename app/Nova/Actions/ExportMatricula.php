<?php

namespace App\Nova\Actions;

use App\Exports\MatriculaExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class ExportMatricula extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $filename = 'matriculas_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        // Create query from selected models
        $query = $models->first()->newQuery()->whereIn('id', $models->pluck('id'));
        
        // Generate the Excel file and return as download
        $export = new MatriculaExport($query);
        
        return Action::download(
            Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX),
            $filename
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return 'Exportar para Excel';
    }
}