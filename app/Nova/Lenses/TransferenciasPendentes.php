<?php

namespace App\Nova\Lenses;

use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use App\Models\TransferRequest;
use Timothyasp\Badge\Badge;

class TransferenciasPendentes extends Lens
{
    public function uriKey()
    {
        return 'transferencias-pendentes';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make('ID', 'id')->sortable(),
            Text::make('Protocolo', 'protocolo'),
            Text::make('Nome do Candidato', 'nome_candidato'),
            // BelongsTo::make('Escola Atual', 'escola', \App\Nova\Escola::class),
            Text::make('Origem', function () {
                $tr = TransferRequest::where('matricula_id', $this->id)->where('status', 'pending')->first();
                return $tr && $tr->fromEscola ? $tr->fromEscola->escola_nome : null;
            })->canSee(function ($request) {
                $tr = TransferRequest::where('matricula_id', $this->id)->where('status', 'pending')->first();
                $user = $request->user();
                if (!$tr || !$user) return false;
                if (method_exists($user, 'hasRole') && $user->hasRole('colegio')) {
                    return (int)($user->escola_id ?? 0) === (int)$tr->to_escola_id;
                }
                return method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin_edu', 'super-admin']);
            }),
            Text::make('Destino', function () {
                $tr = TransferRequest::where('matricula_id', $this->id)->where('status', 'pending')->first();
                return $tr && $tr->toEscola ? $tr->toEscola->escola_nome : null;
            })->canSee(function ($request) {
                $tr = TransferRequest::where('matricula_id', $this->id)->where('status', 'pending')->first();
                $user = $request->user();
                if (!$tr || !$user) return false;
                if (method_exists($user, 'hasRole') && $user->hasRole('colegio')) {
                    return (int)($user->escola_id ?? 0) === (int)$tr->from_escola_id;
                }
                return method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin_edu', 'super-admin']);
            }),
            Badge::make('Transferência')
                ->resolveUsing(function () use ($request) {
                    $tr = TransferRequest::where('matricula_id', $this->id)
                        ->where('status', 'pending')
                        ->first();
                    if (!$tr) {
                        return null;
                    }
                    $user = $request->user();
                    if ($user && method_exists($user, 'hasRole') && $user->hasRole('colegio')) {
                        if ((int)($user->escola_id ?? 0) === (int)$tr->to_escola_id) {
                            return 'Pendente (aceitar)';
                        }
                        if ((int)($user->escola_id ?? 0) === (int)$tr->from_escola_id) {
                            return 'Pendente (origem)';
                        }
                    }
                    return 'Pendente';
                })
                ->options([
                    'Pendente (aceitar)' => 'Pendente (aceitar)',
                    'Pendente (origem)' => 'Pendente (origem)',
                    'Pendente' => 'Pendente',
                ])
                ->colors([
                    'Pendente (aceitar)' => 'blue',
                    'Pendente (origem)' => 'orange',
                    'Pendente' => 'orange',
                ]),
        ];
    }

    public static function query(LensRequest $request, $query)
    {
        $ids = TransferRequest::where('status', 'pending')->pluck('matricula_id')->all();
        return $query->whereIn('id', $ids);
    }

    public function name()
    {
        return 'Transferências pendentes';
    }
}
