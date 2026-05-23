<?php

namespace App\Support;

use App\Models\Matricula;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MatriculaEmails
{
    public static function inscricaoRecebida(Matricula $matricula): void
    {
        self::send(
            $matricula,
            'Inscricao de pre-matricula recebida',
            self::inscricaoTexto($matricula),
            'inscricao_recebida',
        );
    }

    public static function matriculaConfirmada(Matricula $matricula): void
    {
        self::send(
            $matricula,
            'Matricula confirmada',
            self::confirmacaoTexto($matricula),
            'matricula_confirmada',
        );
    }

    protected static function send(Matricula $matricula, string $subject, string $message, string $context): void
    {
        if (blank($matricula->email_responsavel)) {
            return;
        }

        try {
            Mail::raw($message, function ($mail) use ($matricula, $subject): void {
                $mail->to($matricula->email_responsavel)
                    ->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::error('Falha ao enviar e-mail ao responsavel', [
                'contexto' => $context,
                'matricula_id' => $matricula->id,
                'email' => $matricula->email_responsavel,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected static function inscricaoTexto(Matricula $matricula): string
    {
        return "PRE-MATRICULA RECEBIDA\n\n"
            . "Ola, {$matricula->nome_responsavel}.\n\n"
            . "Recebemos a inscricao de pre-matricula de {$matricula->nome_candidato}.\n\n"
            . self::dadosMatricula($matricula)
            . "\nA inscricao foi registrada e esta em analise pela Secretaria de Educacao.\n\n"
            . "Guarde o protocolo para acompanhar o atendimento.\n"
            . "Este e um aviso automatico do sistema de pre-matricula.";
    }

    protected static function confirmacaoTexto(Matricula $matricula): string
    {
        return "MATRICULA CONFIRMADA\n\n"
            . "Ola, {$matricula->nome_responsavel}.\n\n"
            . "A matricula de {$matricula->nome_candidato} foi confirmada.\n\n"
            . self::dadosMatricula($matricula)
            . "\nCompareca ou acompanhe as orientacoes da unidade escolar, quando solicitado.\n\n"
            . "Este e um aviso automatico do sistema de pre-matricula.";
    }

    protected static function dadosMatricula(Matricula $matricula): string
    {
        $encodedId = base64_encode((string) $matricula->id);
        $comprovante = url("/matricula/comprovante/{$encodedId}/d");
        $escola = $matricula->escola?->escola_nome
            ?? $matricula->escola_nome
            ?? 'Nao informado';
        $turma = $matricula->turma_especie ?: 'Nao informado';
        $status = $matricula->statusMatricula?->status_matricula ?: 'Em analise';

        return "Protocolo: {$matricula->protocolo}\n"
            . "Aluno: {$matricula->nome_candidato}\n"
            . "Escola: {$escola}\n"
            . "Turma especie: {$turma}\n"
            . "Ano letivo: {$matricula->ano_letivo}\n"
            . "Situacao: {$status}\n"
            . "Comprovante: {$comprovante}\n";
    }
}
