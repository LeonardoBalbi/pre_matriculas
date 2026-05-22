<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Actions\Action as ActionResponse;

class RestaurarMatricula extends Action
{
    use Queueable;

    public $name = 'Restaurar Matrícula';

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $matricula) {
            $matricula->restore();
        }

        return ActionResponse::message('Matrícula(s) restaurada(s) com sucesso.');
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

        return method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin();
    }
}
