<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\TransferLog;
use App\Models\TransferRequest;
use App\Models\Turma;
use App\Models\User;
use App\Notifications\AjustarTurmaTransferenciaNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function approve(Request $request, $id)
    {
        $transferRequest = TransferRequest::findOrFail($id);

        if (! $request->hasValidSignature()) {
            return redirect('/admin/matriculas')->with('error', 'Assinatura invalida');
        }

        $user = Auth::user();
        $this->approveTransfer($transferRequest, $user ? $user->id : null, $user);

        return redirect('/admin/matriculas')->with('status', 'Transferencia aprovada');
    }

    public function reject(Request $request, $id)
    {
        $transferRequest = TransferRequest::findOrFail($id);

        if (! $request->hasValidSignature()) {
            return redirect('/admin/matriculas')->with('error', 'Assinatura invalida');
        }

        $transferRequest->status = 'rejected';
        $transferRequest->authorized_by = Auth::id();
        $transferRequest->authorized_at = Carbon::now();
        $transferRequest->save();

        return redirect('/admin/matriculas')->with('status', 'Transferencia recusada');
    }

    public function approveDirect(Request $request, $id)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/admin/matriculas')->with('error', 'Nao autenticado');
        }

        $transferRequest = TransferRequest::findOrFail($id);

        if ($redirect = $this->validateDirectUser($user, $transferRequest, 'autorizar')) {
            return $redirect;
        }

        $this->approveTransfer($transferRequest, $user->id, $user);

        return redirect('/admin/matriculas')->with('status', 'Transferencia aprovada');
    }

    public function rejectDirect(Request $request, $id)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/admin/matriculas')->with('error', 'Nao autenticado');
        }

        $transferRequest = TransferRequest::findOrFail($id);

        if ($redirect = $this->validateDirectUser($user, $transferRequest, 'recusar')) {
            return $redirect;
        }

        $transferRequest->status = 'rejected';
        $transferRequest->authorized_by = $user->id;
        $transferRequest->authorized_at = Carbon::now();
        $transferRequest->save();

        TransferLog::create([
            'matricula_id' => $transferRequest->matricula_id,
            'from_escola_id' => $transferRequest->from_escola_id,
            'to_escola_id' => $transferRequest->to_escola_id,
            'action' => 'rejected',
            'by_user_id' => $user->id,
            'reason' => $transferRequest->reason,
        ]);

        return redirect('/admin/matriculas')->with('status', 'Transferencia recusada');
    }

    private function validateDirectUser(User $user, TransferRequest $transferRequest, string $action)
    {
        if ($user->hasRole('colegio')) {
            if ((int) ($user->escola_id ?? 0) !== (int) $transferRequest->to_escola_id) {
                return redirect('/admin/matriculas')->with('error', 'Usuario nao pertence a escola destino');
            }
        } elseif (! $user->hasAnyRole(['admin_edu', 'super-admin'])) {
            return redirect('/admin/matriculas')->with('error', "Sem permissao para {$action}");
        }

        return null;
    }

    private function approveTransfer(TransferRequest $transferRequest, ?int $userId, $user = null): void
    {
        $transferRequest->status = 'approved';
        $transferRequest->authorized_by = $userId;
        $transferRequest->authorized_at = Carbon::now();
        $transferRequest->save();

        $matricula = Matricula::find($transferRequest->matricula_id);

        if (! $matricula) {
            return;
        }

        $matricula->escola_nome_id = $transferRequest->to_escola_id;
        $matricula->pedido_transferencia = 'Transferida';

        if (! empty($matricula->turma_especie)) {
            $tipo = DB::table('turma_tipos')
                ->where('tipo_descricao', $matricula->turma_especie)
                ->first();

            if ($tipo) {
                $novaTurma = Turma::where('turma_escola_id', $transferRequest->to_escola_id)
                    ->where('turma_tipo_id', $tipo->id)
                    ->where('turma_status', 'ativa')
                    ->orderBy('id')
                    ->first();

                if ($novaTurma) {
                    $matricula->turma_id = $novaTurma->id;
                } else {
                    $matricula->turma_id = null;
                    $this->notifyTurmaAdjustment($matricula, $transferRequest->to_escola_id, $user);
                }
            }
        }

        $matricula->save();

        TransferLog::create([
            'matricula_id' => $matricula->id,
            'from_escola_id' => $transferRequest->from_escola_id,
            'to_escola_id' => $transferRequest->to_escola_id,
            'action' => 'approved',
            'by_user_id' => $userId,
            'reason' => $transferRequest->reason,
        ]);
    }

    private function notifyTurmaAdjustment(Matricula $matricula, int $escolaId, $user = null): void
    {
        $notifyUsers = collect();

        if ($user) {
            $notifyUsers->push($user);
        }

        $notifyUsers = $notifyUsers
            ->merge(User::role('colegio')->where('escola_id', $escolaId)->get())
            ->merge(User::role('admin_edu')->get())
            ->unique('id');

        foreach ($notifyUsers as $notifyUser) {
            $notifyUser->notify(new AjustarTurmaTransferenciaNotification($matricula, $escolaId));
        }
    }
}
