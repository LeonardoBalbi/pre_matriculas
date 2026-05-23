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
            Mail::send([], [], function ($mail) use ($matricula, $subject, $message, $context): void {
                $logoCid = null;
                $logoPath = self::logoPath();

                if ($logoPath) {
                    $logoCid = $mail->embed($logoPath);
                }

                $mail->to($matricula->email_responsavel)
                    ->subject($subject)
                    ->html(self::htmlMessage($matricula, $context, $logoCid))
                    ->text($message);
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

    protected static function htmlMessage(Matricula $matricula, string $context, ?string $logoCid): string
    {
        $isConfirmacao = $context === 'matricula_confirmada';
        $title = $isConfirmacao ? 'Matricula confirmada' : 'Pre-matricula recebida';
        $titleHtml = $isConfirmacao ? 'Matr&iacute;cula confirmada' : 'Pr&eacute;-matr&iacute;cula recebida';
        $badgeHtml = $isConfirmacao ? 'Confirmada' : 'Em an&aacute;lise';
        $responsavel = e($matricula->nome_responsavel ?: 'Responsavel');
        $aluno = e($matricula->nome_candidato ?: 'aluno');
        $appName = e(config('app.name', 'Pre-matriculas'));

        $intro = $isConfirmacao
            ? "A matr&iacute;cula de <strong>{$aluno}</strong> foi confirmada."
            : "Recebemos a inscri&ccedil;&atilde;o de pr&eacute;-matr&iacute;cula de <strong>{$aluno}</strong>.";

        $note = $isConfirmacao
            ? 'Compare&ccedil;a ou acompanhe as orienta&ccedil;&otilde;es da unidade escolar, quando solicitado.'
            : 'A inscri&ccedil;&atilde;o foi registrada e est&aacute; em an&aacute;lise pela Secretaria de Educa&ccedil;&atilde;o.';

        $logo = $logoCid
            ? '<img src="' . e($logoCid) . '" width="300" alt="Prefeitura de Mangaratiba" style="display:block;max-width:300px;width:100%;height:auto;margin:0 auto;">'
            : '<div style="font-size:16px;font-weight:700;color:#145ab8;">Prefeitura de Mangaratiba</div>';

        return '<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>' . e($title) . '</title>
</head>
<body style="margin:0;padding:0;background:#f3f6fb;color:#1f2937;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f6fb;padding:28px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border:1px solid #dbe4ee;border-radius:14px;overflow:hidden;">
                    <tr>
                        <td align="center" style="padding:28px 28px 18px;background:#ffffff;">
                            ' . $logo . '
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px 30px;">
                            <div style="display:inline-block;margin-bottom:14px;padding:6px 12px;border-radius:999px;background:#e7f3ff;color:#075985;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">' . $badgeHtml . '</div>
                            <h1 style="margin:0 0 12px;font-size:26px;line-height:1.2;color:#0f172a;">' . $titleHtml . '</h1>
                            <p style="margin:0 0 22px;font-size:16px;line-height:1.6;color:#475569;">Ol&aacute;, ' . $responsavel . '.<br>' . $intro . '</p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:separate;border-spacing:0;border:1px solid #dbe4ee;border-radius:12px;overflow:hidden;">
                                ' . self::dadosMatriculaHtml($matricula) . '
                            </table>
                            <p style="margin:22px 0 0;font-size:15px;line-height:1.6;color:#475569;">' . $note . '</p>
                            <p style="margin:18px 0 0;font-size:13px;line-height:1.5;color:#64748b;">Este &eacute; um aviso autom&aacute;tico do sistema de pr&eacute;-matr&iacute;cula.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:18px 24px;background:#f8fafc;color:#64748b;font-size:12px;line-height:1.5;">
                            ' . $appName . '
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    }

    protected static function dadosMatricula(Matricula $matricula): string
    {
        $dados = '';

        foreach (self::dadosMatriculaItens($matricula) as $label => $value) {
            $dados .= "{$label}: {$value}\n";
        }

        return $dados;
    }

    protected static function dadosMatriculaHtml(Matricula $matricula): string
    {
        $rows = '';

        foreach (self::dadosMatriculaItens($matricula) as $label => $value) {
            $rows .= '<tr>
                <td style="padding:12px 14px;background:#f8fafc;border-bottom:1px solid #e5edf6;width:38%;font-size:13px;font-weight:700;color:#475569;">' . e($label) . '</td>
                <td style="padding:12px 14px;border-bottom:1px solid #e5edf6;font-size:14px;color:#0f172a;">' . e((string) $value) . '</td>
            </tr>';
        }

        return $rows;
    }

    protected static function dadosMatriculaItens(Matricula $matricula): array
    {
        $escola = $matricula->escola?->escola_nome
            ?? $matricula->escola_nome
            ?? 'Nao informado';
        $turma = $matricula->turma_especie ?: 'Nao informado';

        return [
            'Protocolo' => $matricula->protocolo ?: 'Nao informado',
            'Aluno' => $matricula->nome_candidato ?: 'Nao informado',
            'Escola' => $escola,
            'Turma especie' => $turma,
            'Ano letivo' => $matricula->ano_letivo ?: 'Nao informado',
        ];
    }

    protected static function logoPath(): ?string
    {
        $path = public_path('img/logo_governo_azul.png');

        return is_file($path) ? $path : null;
    }
}
