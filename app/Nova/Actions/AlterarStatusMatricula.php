<?php

namespace App\Nova\Actions;

use App\Models\StatusMatricula;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class AlterarStatusMatricula extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * O nome exibido para a action.
     *
     * @var string
     */
    public $name = 'Alterar Status em Massa';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $statusId = $fields->status;
        $observacao = $fields->observacao;

        foreach ($models as $model) {
            $model->situacao_matricula = $statusId;
            
            if ($observacao) {
                // Adiciona a observação ao que já existe, se houver
                $dataAtual = now()->format('d/m/Y H:i');
                $novaObs = "[$dataAtual] Alteração de status em massa: " . $observacao;
                $model->observacao = $model->observacao ? $model->observacao . "\n" . $novaObs : $novaObs;
            }

            $model->save();
        }

        return Action::message('Status atualizado com sucesso para ' . $models->count() . ' registro(s)!');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $statuses = StatusMatricula::all()->pluck('status_matricula', 'id')->toArray();

        return [
            Select::make('Novo Status', 'status')
                ->options($statuses)
                ->rules('required')
                ->displayUsingLabels(),

            Textarea::make('Observação (Opcional)', 'observacao')
                ->help('Esta observação será adicionada ao histórico da matrícula.'),
        ];
    }
}
