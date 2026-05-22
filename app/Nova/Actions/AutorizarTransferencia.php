<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use App\Models\TransferRequest;
use App\Models\TransferLog;
use App\Models\Turma;
use Laravel\Nova\Actions\Action as ActionResponse;

class AutorizarTransferencia extends Action
{
    use Queueable;

    public $name = 'Autorizar transferência';

    public function handle(ActionFields $fields, Collection $models)
    {
        $user = auth()->user();
        if (!$user) {
            return ActionResponse::danger('Usuário não autenticado.');
        }

        $aprovadas = 0;
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

            $tr->status = 'approved';
            $tr->authorized_by = $user->id;
            $tr->authorized_at = now();
            $tr->save();

            $matricula->escola_nome_id = $tr->to_escola_id;
            $matricula->pedido_transferencia = 'Transferida';

            if (!empty($matricula->turma_especie)) {
                $tipo = \DB::table('turma_tipos')->where('tipo_descricao', $matricula->turma_especie)->first();
                if ($tipo) {
                    $novaTurma = Turma::where('turma_escola_id', $tr->to_escola_id)
                        ->where('turma_tipo_id', $tipo->id)
                        ->where('turma_status', 'ativa')
                        ->orderBy('id')
                        ->first();
                    if ($novaTurma) {
                        $matricula->turma_id = $novaTurma->id;
                    } else {
                        $matricula->turma_id = null;
                    }
                }
            }
            $matricula->save();

            TransferLog::create([
                'matricula_id' => $matricula->id,
                'from_escola_id' => $tr->from_escola_id,
                'to_escola_id' => $tr->to_escola_id,
                'action' => 'approved',
                'by_user_id' => $user->id,
                'reason' => $tr->reason,
            ]);

            $aprovadas++;
        }

        if ($aprovadas === 0) {
            return ActionResponse::danger('Nenhuma transferência pendente autorizável para os itens selecionados.');
        }

        return ActionResponse::message("Transferência(s) aprovadas: {$aprovadas}.");
    }
}
