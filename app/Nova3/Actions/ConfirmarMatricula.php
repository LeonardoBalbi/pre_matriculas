<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\StatusMatricula;
use App\Notifications\NovaAbrirWhatsappMatricula;
use Laravel\Nova\Actions\Action as ActionResponse;
use Illuminate\Support\Facades\Mail;

class ConfirmarMatricula extends Action
{
    use Queueable;

    public $name = 'Confirmar matrícula';

    public function handle(ActionFields $fields, Collection $models)
    {
        $matriculadoId = StatusMatricula::where('status_matricula', 'Matriculado')->value('id');

        $waUrl = null;
        foreach ($models as $matricula) {
            if ($matriculadoId) {
                $matricula->situacao_matricula = $matriculadoId;
                $user = auth()->user();
                if ($user) {
                    $user->notify(new NovaAbrirWhatsappMatricula($matricula));
                }
                $matricula->save();

                $telefone = $matricula->tel_cel_responsavel;
                $digits = preg_replace('/[^0-9]/', '', (string) $telefone);
                if ($digits && substr($digits, 0, 2) !== '55') {
                    $digits = '55' . $digits;
                }
                if (strlen($digits) === 12) {
                    $digits = substr($digits, 0, 4) . '9' . substr($digits, 4);
                }
                $encodedId = base64_encode((string) $matricula->id);
                $comp = url("/matricula/comprovante/{$encodedId}/d");
                $escola = $matricula->escola ? $matricula->escola->escola_nome : 'Não informado';
                $msg = "MATRÍCULA CONFIRMADA\n\nProtocolo: {$matricula->protocolo}\nAluno: {$matricula->nome_candidato}\nEscola: {$escola}\nAno Letivo: {$matricula->ano_letivo}\nComprovante: {$comp}";
                $waUrl = "https://web.whatsapp.com/send/?phone={$digits}&text=" . urlencode($msg);

                if (!empty($matricula->email_responsavel)) {
                    $texto = "MATRÍCULA CONFIRMADA\n\n"
                        . "Protocolo: {$matricula->protocolo}\n"
                        . "Aluno: {$matricula->nome_candidato}\n"
                        . "Escola: {$escola}\n"
                        . "Ano Letivo: {$matricula->ano_letivo}\n"
                        . "Comprovante: {$comp}\n\n"
                        . "Este é um aviso automático do sistema de pré-matrícula.";
                    try {
                        Mail::raw($texto, function ($m) use ($matricula) {
                            $m->to($matricula->email_responsavel)->subject('Matrícula confirmada');
                        });
                    } catch (\Throwable $e) {
                    }
                }
            }
        }

        if ($waUrl) {
            if (method_exists(ActionResponse::class, 'openInNewTab')) {
                return ActionResponse::openInNewTab($waUrl);
            }
            return ActionResponse::redirectTo($waUrl);
        }

        return ActionResponse::message('Matrícula(s) confirmada(s).');
    }

    public function fields(NovaRequest $request)
    {
        return [];
    }

    public function authorizedToRun(Request $request, $model)
    {
        $user = $request->user();
        if (!$user) {
            return false;
        }

        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return true;
        }

        return $user->hasAnyRole(['admin', 'colegio']);
    }
}
