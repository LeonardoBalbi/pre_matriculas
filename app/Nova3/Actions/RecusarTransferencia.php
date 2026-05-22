<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use App\Models\TransferRequest;
use App\Models\TransferLog;
use Laravel\Nova\Actions\Action as ActionResponse;

class RecusarTransferencia extends Action
{
    use Queueable;

    public $name = 'Recusar transferência';

    public function handle(ActionFields $fields, Collection $models)
    {
        $user = auth()->user();
        if (!$user) {
            return ActionResponse::danger('Usuário não autenticado.');
        }

        $recusadas = 0;
        foreach ($models as $matricula) {
            $tr = TransferRequest::where('matricula_id', $matricula->id)
                ->where('status', 'pending')
                ->when($user->hasRole('colegio'), fn ($q) => $q->where('to_escola_id', $user->escola_id))
                ->first();

            if (!$tr) {
                continue;
            }

            if (!($user->hasAnyRole(['super-admin', 'admin_edu']) || ($user->hasRole('colegio') && (int)$user->escola_id === (int)$tr->to_escola_id))) {
                continue;
            }

            $tr->status = 'rejected';
            $tr->authorized_by = $user->id;
            $tr->authorized_at = now();
            $tr->save();

            TransferLog::create([
                'matricula_id' => $matricula->id,
                'from_escola_id' => $tr->from_escola_id,
                'to_escola_id' => $tr->to_escola_id,
                'action' => 'rejected',
                'by_user_id' => $user->id,
                'reason' => $tr->reason,
            ]);

            $recusadas++;
        }

        if ($recusadas === 0) {
            return ActionResponse::danger('Nenhuma transferência pendente recusável para os itens selecionados.');
        }

        return ActionResponse::message("Transferência(s) recusadas: {$recusadas}.");
    }
}
