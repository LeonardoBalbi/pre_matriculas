<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class CpfAutorizado extends Resource
{
    public static $model = \App\Models\CpfAutorizado::class;

    public static $title = 'cpf';

    public static $group = 'Administração';

    public static $search = [
        'id', 'cpf', 'motivo',
    ];

    public static function label() {
        return 'CPFs Utilizados (Bloqueio)';
    }

    public static function availableForNavigation(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return false;
        }
        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return true;
        }
        return method_exists($user, 'hasRole') && $user->hasRole('admin_edu');
    }

    public static function authorizedToViewAny(Request $request)
    {
        return static::availableForNavigation($request);
    }

    public static function authorizedToCreate(Request $request)
    {
        return static::availableForNavigation($request);
    }

    public function authorizedToUpdate(Request $request)
    {
        return static::availableForNavigation($request);
    }

    public function authorizedToDelete(Request $request)
    {
        return static::availableForNavigation($request);
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('CPF', 'cpf')
                ->rules('required', 'max:14')
                ->creationRules('unique:cpf_autorizados,cpf')
                ->updateRules('unique:cpf_autorizados,cpf,{{resourceId}}')
                ->help('CPFs nesta lista estão BLOQUEADOS para novos cadastros duplicados. Exclua o registro deste CPF para permitir um novo cadastro para o mesmo aluno.'),

            Textarea::make('Origem / Motivo', 'motivo')
                ->rules('required'),

            BelongsTo::make('Autorizado Por', 'user', User::class)
                ->readonly()
                ->exceptOnForms(),
        ];
    }
}
