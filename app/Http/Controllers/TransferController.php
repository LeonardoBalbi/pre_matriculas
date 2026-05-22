<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferRequest;
use App\Models\Matricula;
use App\Models\TransferLog;
use App\Models\Turma;
use App\Models\User;
use App\Notifications\NovaAjustarTurmaTransferencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class TransferController extends Controller
{
    public function approve(Request $request, $id)
    {
        $tr = TransferRequest::findOrFail($id);
        if (!$request->hasValidSignature()) {
            return redirect('/admin/resources/colegios')->with('error', 'Assinatura inválida');
        }
        $user = Auth::user();
        $tr->status = 'approved';
        $tr->authorized_by = $user ? $user->id : null;
        $tr->authorized_at = Carbon::now();
        $tr->save();

        $mat = Matricula::find($tr->matricula_id);
        if ($mat) {
            $mat->escola_nome_id = $tr->to_escola_id;
            $mat->pedido_transferencia = 'Transferida';
            if (!empty($mat->turma_especie)) {
                $tipo = \DB::table('turma_tipos')->where('tipo_descricao', $mat->turma_especie)->first();
                if ($tipo) {
                    $novaTurma = Turma::where('turma_escola_id', $tr->to_escola_id)
                        ->where('turma_tipo_id', $tipo->id)
                        ->where('turma_status', 'ativa')
                        ->orderBy('id')
                        ->first();
                    if ($novaTurma) {
                        $mat->turma_id = $novaTurma->id;
                    } else {
                        $mat->turma_id = null;
                        $notifyUsers = collect();
                        if ($user) {
                            $notifyUsers = $notifyUsers->push($user);
                        }
                        $notifyUsers = $notifyUsers->merge(User::role('colegio')->where('escola_id', $tr->to_escola_id)->get());
                        $notifyUsers = $notifyUsers->merge(User::role('admin_edu')->get());
                        foreach ($notifyUsers as $u) {
                            $u->notify(new NovaAjustarTurmaTransferencia($mat, $tr->to_escola_id));
                        }
                    }
                }
            }
            $mat->save();

            TransferLog::create([
                'matricula_id' => $mat->id,
                'from_escola_id' => $tr->from_escola_id,
                'to_escola_id' => $tr->to_escola_id,
                'action' => 'approved',
                'by_user_id' => $user ? $user->id : null,
                'reason' => $tr->reason,
            ]);
        }

        return redirect('/admin/resources/colegios')->with('status', 'Transferência aprovada');
    }

    public function reject(Request $request, $id)
    {
        $tr = TransferRequest::findOrFail($id);
        if (!$request->hasValidSignature()) {
            return redirect('/admin/resources/colegios')->with('error', 'Assinatura inválida');
        }
        $user = Auth::user();
        $tr->status = 'rejected';
        $tr->authorized_by = $user ? $user->id : null;
        $tr->authorized_at = Carbon::now();
        $tr->save();

        return redirect('/admin/resources/colegios')->with('status', 'Transferência recusada');
    }

    public function approveDirect(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/admin/resources/colegios')->with('error', 'Não autenticado');
        }
        $tr = TransferRequest::findOrFail($id);
        if ($user->hasRole('colegio')) {
            if ((int)($user->escola_id ?? 0) !== (int)$tr->to_escola_id) {
                return redirect('/admin/resources/colegios')->with('error', 'Usuário não pertence à escola destino');
            }
        } elseif (!$user->hasAnyRole(['admin_edu', 'super-admin'])) {
            return redirect('/admin/resources/colegios')->with('error', 'Sem permissão para autorizar');
        }

        $tr->status = 'approved';
        $tr->authorized_by = $user->id;
        $tr->authorized_at = Carbon::now();
        $tr->save();

        $mat = Matricula::find($tr->matricula_id);
        if ($mat) {
            $mat->escola_nome_id = $tr->to_escola_id;
            $mat->pedido_transferencia = 'Transferida';
            if (!empty($mat->turma_especie)) {
                $tipo = \DB::table('turma_tipos')->where('tipo_descricao', $mat->turma_especie)->first();
                if ($tipo) {
                    $novaTurma = Turma::where('turma_escola_id', $tr->to_escola_id)
                        ->where('turma_tipo_id', $tipo->id)
                        ->where('turma_status', 'ativa')
                        ->orderBy('id')
                        ->first();
                    if ($novaTurma) {
                        $mat->turma_id = $novaTurma->id;
                    } else {
                        $mat->turma_id = null;
                        $notifyUsers = collect([$user]);
                        $notifyUsers = $notifyUsers->merge(\App\Models\User::role('admin_edu')->get());
                        foreach ($notifyUsers as $u) {
                            $u->notify(new \App\Notifications\NovaAjustarTurmaTransferencia($mat, $tr->to_escola_id));
                        }
                    }
                }
            }
            $mat->save();

            TransferLog::create([
                'matricula_id' => $mat->id,
                'from_escola_id' => $tr->from_escola_id,
                'to_escola_id' => $tr->to_escola_id,
                'action' => 'approved',
                'by_user_id' => $user->id,
                'reason' => $tr->reason,
            ]);
        }

        return redirect('/admin/resources/colegios')->with('status', 'Transferência aprovada');
    }

    public function rejectDirect(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/admin/resources/colegios')->with('error', 'Não autenticado');
        }
        $tr = TransferRequest::findOrFail($id);
        if ($user->hasRole('colegio')) {
            if ((int)($user->escola_id ?? 0) !== (int)$tr->to_escola_id) {
                return redirect('/admin/resources/colegios')->with('error', 'Usuário não pertence à escola destino');
            }
        } elseif (!$user->hasAnyRole(['admin_edu', 'super-admin'])) {
            return redirect('/admin/resources/colegios')->with('error', 'Sem permissão para recusar');
        }

        $tr->status = 'rejected';
        $tr->authorized_by = $user->id;
        $tr->authorized_at = Carbon::now();
        $tr->save();

        TransferLog::create([
            'matricula_id' => $tr->matricula_id,
            'from_escola_id' => $tr->from_escola_id,
            'to_escola_id' => $tr->to_escola_id,
            'action' => 'rejected',
            'by_user_id' => $user->id,
            'reason' => $tr->reason,
        ]);

        return redirect('/admin/resources/colegios')->with('status', 'Transferência recusada');
    }
}
