<?php

namespace App\Nova\Actions;

use App\Models\StatusMatricula;
use App\Notifications\NovaAbrirWhatsappMatricula;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\Action as ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ConfirmarMatricula extends Action
{
    use Queueable;

    public $name = 'Confirmar matricula';

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
                $escola = $matricula->escola ? $matricula->escola->escola_nome : 'Nao informado';
                $msg = "MATRICULA CONFIRMADA\n\nProtocolo: {$matricula->protocolo}\nAluno: {$matricula->nome_candidato}\nEscola: {$escola}\nAno Letivo: {$matricula->ano_letivo}\nComprovante: {$comp}";
                $waUrl = "https://web.whatsapp.com/send/?phone={$digits}&text=" . urlencode($msg);
            }
        }

        if ($waUrl) {
            if (method_exists(ActionResponse::class, 'openInNewTab')) {
                return ActionResponse::openInNewTab($waUrl);
            }

            return ActionResponse::redirectTo($waUrl);
        }

        return ActionResponse::message('Matricula(s) confirmada(s).');
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
