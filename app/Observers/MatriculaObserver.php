<?php

namespace App\Observers;

use App\Models\CpfAutorizado;
use App\Models\Matricula;
use App\Models\MatriculaDeletedLog;
use App\Models\User;
use App\Notifications\MatriculaCriadaNotification;
use App\Support\MatriculaEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MatriculaObserver
{
    /**
     * Handle the Matricula "created" event.
     */
    public function created(Matricula $matricula): void
    {
        // Registra o CPF na tabela de bloqueio para impedir duplicidade futura
        // A menos que o admin remova manualmente deste registro.
        if (! empty($matricula->cpf_candidato)) {
            CpfAutorizado::firstOrCreate(
                ['cpf' => preg_replace('/\D+/', '', $matricula->cpf_candidato)],
                ['motivo' => 'Cadastro realizado em '.now()->format('d/m/Y')]
            );
        }

        // Notificar todos os usuários com o papel 'admin_edu'
        $usuarios = User::role(['admin_edu', 'super-admin'])->get();

        foreach ($usuarios as $usuario) {
            try {
                $usuario->notify(new MatriculaCriadaNotification($matricula));
            } catch (\Throwable $e) {
                Log::error('Falha ao notificar usuário admin_edu', [
                    'user_id' => $usuario->id,
                    'email' => $usuario->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        MatriculaEmails::inscricaoRecebida($matricula);

        if ($this->isMatriculado($matricula)) {
            MatriculaEmails::matriculaConfirmada($matricula);
        }

        // Limpar o cache
        $this->clearCache();
    }

    /**
     * Handle the Matricula "updated" event.
     */
    public function updated(Matricula $matricula): void
    {
        $original = $matricula->getOriginal('situacao_matricula');
        $current = $matricula->situacao_matricula;
        $isDesistente = false;
        if (is_numeric($current) && (int) $current === 12) {
            $isDesistente = true;
        } else {
            $status = $matricula->statusMatricula;
            $nome = $status ? ($status->status_matricula ?? $status->situacao_matricula) : null;
            if (is_string($nome) && strtolower($nome) === 'desistente') {
                $isDesistente = true;
            }
        }
        if ($original !== $current && $isDesistente && ! empty($matricula->cpf_candidato)) {
            $cpf = preg_replace('/\D+/', '', $matricula->cpf_candidato);
            CpfAutorizado::where('cpf', $cpf)->delete();
        }

        if ($original !== $current && $this->isMatriculado($matricula)) {
            MatriculaEmails::matriculaConfirmada($matricula);
        }

        $this->clearCache();
    }

    /**
     * Handle the Matricula "deleted" event.
     */
    public function deleted(Matricula $matricula): void
    {
        // Criar log de exclusão
        MatriculaDeletedLog::create([
            'matricula_id' => $matricula->id,
            'deleted_by' => Auth::id(),
            'deleted_by_name' => Auth::user() ? Auth::user()->name : 'Sistema',
            'motivo_exclusao' => request('motivo_exclusao') ?? 'Não informado',
            'dados_matricula' => $matricula->toArray(),
        ]);

        // Limpar o cache
        $this->clearCache();
    }

    /**
     * Limpa o cache da aplicação
     */
    private function clearCache(): void {}

    private function isMatriculado(Matricula $matricula): bool
    {
        if (is_numeric($matricula->situacao_matricula) && (int) $matricula->situacao_matricula === 11) {
            return true;
        }

        $status = $matricula->statusMatricula;
        $nome = $status ? ($status->status_matricula ?? $status->situacao_matricula) : null;

        return is_string($nome) && mb_strtolower($nome) === 'matriculado';
    }
}
