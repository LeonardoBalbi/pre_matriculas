<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use App\Models\TransferRequest;
use App\Models\Escola;
use App\Models\User;
use App\Notifications\NovaAutorizarTransferencia;
use Laravel\Nova\Actions\Action as ActionResponse;

class TransferirMatricula extends Action
{
    use Queueable;

    public $name = 'Solicitar transferência';

    public function handle(ActionFields $fields, Collection $models)
    {
        $user = auth()->user();
        $toId = (int)($fields->to_escola_id ?? 0);
        if (!$user || !$toId) {
            return ActionResponse::danger('Selecione a escola de destino.');
        }
        $toEscola = Escola::find($toId);
        if (!$toEscola) {
            return ActionResponse::danger('Escola de destino inválida.');
        }

        foreach ($models as $matricula) {
            $fromId = $matricula->escola_nome_id ?: 0;
            $tr = TransferRequest::create([
                'matricula_id' => $matricula->id,
                'from_escola_id' => $fromId,
                'to_escola_id' => $toId,
                'requested_by' => $user->id,
                'status' => 'pending',
                'reason' => $fields->reason,
            ]);
            $matricula->pedido_transferencia = 'Solicitada';
            $matricula->save();

            $destUsers = User::role('colegio')->where('escola_id', $toId)->get();
            foreach ($destUsers as $u) {
                $u->notify(new NovaAutorizarTransferencia($tr));
            }
        }

        return ActionResponse::message('Transferência solicitada. Aguardando autorização da escola destino.');
    }

    public function fields(NovaRequest $request)
    {
        $options = Escola::query()->pluck('escola_nome', 'id')->toArray();
        return [
            Select::make('Escola de destino', 'to_escola_id')->options($options)->rules('required'),
            Textarea::make('Motivo', 'reason')->nullable(),
        ];
    }
}
