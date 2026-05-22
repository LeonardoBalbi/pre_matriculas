<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Timothyasp\Badge\Badge;
use App\Models\StatusMatricula;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Lenses\MatriculadosLens;
use App\Nova\Actions\ConfirmarMatricula;
use App\Nova\Actions\TransferirMatricula;
use App\Nova\Actions\AutorizarTransferencia;
use App\Nova\Actions\RecusarTransferencia;
use App\Models\TransferRequest;
use App\Models\TransferLog;

class Colegio extends Resource
{
    /**
     * Model associado
     */
    public static $model = \App\Models\Matricula::class;

    public static function uriKey()
    {
        return 'colegios';
    }

    public static function label()
    {
        return 'Ceim - Matrículas';
    }

    public static $title = 'nome_candidato';

    public static $group = 'Classificados';

    public static $search = [
        'id',
        'protocolo',
        'nome_candidato',
    ];

    public function fields(NovaRequest $request)
    {
        $user = $request->user();

        // Status
        $statusCollection = StatusMatricula::all();
        $allStatusOptions = $statusCollection->pluck('status_matricula', 'id')->all();

        // Restrição de status para papel "colegio"
        if ($user && $user->hasRole('colegio')) {
            $statusPermitido = $statusCollection
                ->firstWhere('status_matricula', 'Apto a fazer matricula');

            $statusOptions = $statusPermitido
                ? [$statusPermitido->id => $statusPermitido->status_matricula]
                : $allStatusOptions;
        } else {
            $statusOptions = $allStatusOptions;
        }

        return [
            ID::make()->sortable()->readonly(),

            Text::make('Aceitar', function () use ($request) {
                $tr = TransferRequest::where('matricula_id', $this->id)
                    ->where('status', 'pending')
                    ->first();
                if (!$tr) {
                    return null;
                }
                $user = $request->user();
                $canAccept = $user
                    && (
                        ($user->hasRole('colegio') && (int)($user->escola_id ?? 0) === (int)$tr->to_escola_id) ||
                        $user->hasAnyRole(['admin_edu', 'super-admin', 'admin'])
                    );
                return $canAccept
                    ? '<a class="link-default" href="' . route('admin.transfer.approve-direct', ['id' => $tr->id]) . '">ACEITAR</a>'
                    : null;
            })->asHtml()->onlyOnIndex(),

            // Status (index)
            Text::make('Status', function () use ($allStatusOptions) {
                return $allStatusOptions[$this->situacao_matricula]
                    ?? $this->situacao_matricula;
            })->onlyOnIndex(),

            // Status (form)
            Select::make('Status', 'situacao_matricula')
                ->options($statusOptions)
                ->displayUsingLabels()
                ->onlyOnForms(),

            // Indicador de transferência
            Badge::make('Transferência', 'transferencia_status')
                ->resolveUsing(function () use ($request) {
                    $tr = TransferRequest::where('matricula_id', $this->id)
                        ->where('status', 'pending')
                        ->first();
                    if (!$tr) {
                        return $this->pedido_transferencia ?: null;
                    }
                    $user = $request->user();
                    if ($user && $user->hasRole('colegio') && (int)($user->escola_id ?? 0) === (int)$tr->to_escola_id) {
                        return 'Pendente (aceitar)';
                    }
                    return 'Pendente (origem)';
                })
                ->exceptOnForms()
                ->options([
                    'Pendente (aceitar)' => 'Pendente (aceitar)',
                    'Pendente (origem)' => 'Pendente (origem)',
                    'Solicitada' => 'Solicitada',
                    'Transferida' => 'Transferida',
                ])
                ->colors([
                    'Pendente (aceitar)' => 'blue',
                    'Pendente (origem)' => 'orange',
                    'Solicitada' => 'orange',
                    'Transferida' => 'green',
                ])
                ->showOnIndex()
                ->showOnDetail(),

            Text::make('Protocolo', 'protocolo')
                ->sortable()
                ->rules('required')
                ->readonly(fn ($request) =>
                    $request->user()?->hasRole('colegio')
                ),

            Text::make('Nome do Candidato', 'nome_candidato')
                ->sortable()
                ->rules('required')
                ->readonly(fn ($request) =>
                    $request->user()?->hasRole('colegio')
                ),

            /**
             * ✅ BADGE DE TURMA
             * (IGUAL AO RESOURCE Matricula)
             */
            Badge::make('Turma', 'turma_especie')
                ->options([
                    'INFANTIL 1' => 'INFANTIL 1',
                    'INFANTIL 2' => 'INFANTIL 2',
                    'INFANTIL 3' => 'INFANTIL 3',
                    'Não atribuída' => 'Não atribuída',
                ])
                ->colors([
                    'BERÇÁRIO'      => 'blue',
                    'BERÇÁRIO A'    => 'blue',
                    'BERÇÁRIO B'    => 'cyan',
                    'INFANTIL 1'    => 'cyan',
                    'INFANTIL 2'    => 'green',
                    'Nível 1'       => 'green',
                    'INFANTIL 3'    => 'orange',
                    'Nível 2'       => 'orange',
                    'Não atribuída' => 'gray',
                ])
                ->showOnIndex()
                ->hideWhenCreating()
               ->hideWhenUpdating()
                ->showOnDetail(),

            // Timeline de transferência (somente no detalhe)
            \Laravel\Nova\Fields\Text::make('Timeline da Transferência', function () {
                $logs = TransferLog::where('matricula_id', $this->id)
                    ->orderBy('id', 'desc')
                    ->get();
                if ($logs->isEmpty()) {
                    return 'Sem movimentações de transferência.';
                }
                $html = '<ul style="padding-left:18px;">';
                foreach ($logs as $log) {
                    $html .= '<li>'
                          . e($log->created_at) . ' — '
                          . e($log->action) . ' | '
                          . 'de #' . e($log->from_escola_id) . ' para #' . e($log->to_escola_id)
                          . '</li>';
                }
                $html .= '</ul>';
                return $html;
            })->asHtml()->onlyOnDetail(),

        ];
    }

    /**
     * Filtra apenas status 12 e 13
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $user = $request->user();

        if ($user && method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return $query;
        }

        // Filtro de status dinâmico para garantir exibição de "Apto a fazer matricula"
        $statusPermitidos = StatusMatricula::whereIn('status_matricula', [
            'Apto a fazer matricula',
        ])->pluck('id')->all();
        if (empty($statusPermitidos)) {
            // fallback legado
            $statusPermitidos = [12, 13];
        }
        $query->whereIn('situacao_matricula', $statusPermitidos);

        if ($user && $user->hasRole('colegio') && !empty($user->escola_id)) {
            // Mostrar matrículas da escola e também transferências pendentes cujo destino é a escola do usuário
            $escolaId = (int) $user->escola_id;
            $query->where(function ($q) use ($escolaId) {
                $q->where('escola_nome_id', $escolaId)
                  ->orWhereExists(function ($sub) use ($escolaId) {
                      $sub->select(\DB::raw(1))
                          ->from('transfer_requests')
                          ->whereColumn('transfer_requests.matricula_id', 'matriculas.id')
                          ->where('transfer_requests.to_escola_id', $escolaId)
                          ->where('transfer_requests.status', 'pending');
                  });
            });
        }

        return $query;
    }

    /**
     * Permite atualização
     */
    public function authorizedToUpdate(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return false;
        }

        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return true;
        }

        // Bloqueia edição para "colegio" enquanto houver transferência pendente
        $hasPending = TransferRequest::where('matricula_id', $this->id)->where('status', 'pending')->exists();
        if ($hasPending && $user->hasRole('colegio')) {
            return false;
        }
        return $user->hasAnyRole(['admin', 'admin_edu', 'colegio']);
    }

    public function lenses(NovaRequest $request)
    {
        return [
            new MatriculadosLens(),
            new \App\Nova\Lenses\TransferenciasPendentes(),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            (new ConfirmarMatricula())
                ->canSee(fn ($request) =>
                    $request->user()?->hasAnyRole(['super_admin', 'admin', 'admin_edu', 'colegio'])
                )
                ->canRun(fn ($request) =>
                    $request->user()?->hasAnyRole(['super_admin', 'admin', 'admin_edu', 'colegio'])
                ),
            (new TransferirMatricula())
                ->canSee(fn ($request) =>
                    $request->user()?->hasAnyRole(['super_admin', 'admin', 'admin_edu', 'colegio'])
                )
                ->canRun(fn ($request) =>
                    $request->user()?->hasAnyRole(['super_admin', 'admin', 'admin_edu', 'colegio'])
                ),
            (new AutorizarTransferencia())
                ->canSee(fn ($request) =>
                    $request->user()?->hasAnyRole(['super_admin', 'admin', 'admin_edu', 'colegio'])
                )
                ->canRun(fn ($request) =>
                    $request->user()?->hasAnyRole(['super_admin', 'admin', 'admin_edu', 'colegio'])
                ),
            (new RecusarTransferencia())
                ->canSee(fn ($request) =>
                    $request->user()?->hasAnyRole(['super_admin', 'admin', 'admin_edu', 'colegio'])
                )
                ->canRun(fn ($request) =>
                    $request->user()?->hasAnyRole(['super_admin', 'admin', 'admin_edu', 'colegio'])
                ),
        ];
    }
}
