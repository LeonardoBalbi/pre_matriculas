<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Year;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Carbon\Carbon;
use Timothyasp\Badge\Badge;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\Boolean;
use Illuminate\Support\Facades\Log;
use App\Models\Matricula as ModelsMatricula;
use App\Nova\Filters\EscolaMatriculaFilter;
use App\Nova\Filters\TurmaMatriculaFilter;

use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

use App\Models\StatusMatricula;
use App\Models\Turma;
use Rhylton\Escolas\Escolas;
use Rhyltonn\Turmas\Turmas;
use App\Nova\Actions\ExportarMatriculasExcel;
use App\Nova\Actions\ConfirmarMatricula;
use App\Nova\Actions\AlterarStatusMatricula;
use App\Models\TransferRequest;


class Matricula extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Matricula>
     */
    public static $model = \App\Models\Matricula::class;

    public static $displayInNavigation = true;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'nome_candidato';

    public static function label()
    {
        return 'Pre-Matrículas';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'nome_candidato', 'data_inscricao', 'protocolo', 'situacao_matricula', 'data_nascimento', 'cpf_candidato', 'idade','portador_deficiencia', 'endereco', 'nome_responsavel', 'email_responsavel', 'cpf_responsavel', 'vulneravel_social', 'escola.escola_nome',
    ];

    // protected static function booted()
    // {
    //     static::creating(function ($model) {
    //         $model->ANO_LETIVO = now()->year;
    //     });
    // }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $status_matricula = StatusMatricula::all();

        $mat_cor_status = $status_matricula->pluck('status_matricula', 'id')->all();
        $mat_cor_op = $status_matricula->pluck('color', 'id')->all();

        return [
            id::make()->sortable(),

            text::make('nome da criança', 'nome_candidato')->nullable(),
            Badge::make('Turma', 'turma_especie')
            ->options([
                
                'BERÇÁRIO' => 'BERÇÁRIO',
                'INFANTIL 1' => 'INFANTIL 1',
                'INFANTIL 2' => 'INFANTIL 2',
                'INFANTIL 3' => 'INFANTIL 3',
                'Não atribuída' => 'Não atribuída',
            ])
            ->colors([
                'BERÇÁRIO' => 'blue',
                'BERÇÁRIO A' => 'blue',
                'INFANTIL 1' => 'cyan',
                'BERÇÁRIO B' => 'cyan',
                'INFANTIL 2' => 'green',
                'Nível 1' => 'green',
                'INFANTIL 3' => 'orange',
                'Nível 2' => 'orange',
                'Não atribuída' => 'gray',
            ])
            ->showOnIndex()
            ->showOnDetail()
            ->showOnCreating()
            ->showOnUpdating(),

            // Text::make('Turma', function () {
            //     return optional($this->turmatipo)->tipo_descricao ?? '';
            // })->onlyOnIndex(),
            Badge::make('Status', 'situacao_matricula')
            ->options($mat_cor_status)
            ->colors($mat_cor_op)->displayUsingLabels(),
        Badge::make('Transferência', 'transferencia')
                ->resolveUsing(function () use ($request) {
                    $tr = TransferRequest::where('matricula_id', $this->id)
                        ->where('status', 'pending')
                        ->first();
                    if (!$tr) {
                        return $this->pedido_transferencia ?: null;
                    }
                    $user = $request->user();
                    if ($user && method_exists($user, 'hasRole') && $user->hasRole('colegio') && (int)($user->escola_id ?? 0) === (int)$tr->to_escola_id) {
                        return 'Pendente (aceitar)';
                    }
                    return 'Pendente (origem)';
                })
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
            number::make('protocolo', 'protocolo')->sortable()->hideWhenCreating()->nullable(),
            DateTime::make('data de inscricao', 'created_at')
                ->displayUsing(function ($value) {
                    return $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : null;
                })
                ->nullable()
                ->hideWhenCreating(),
            Number::make('ano_letivo', 'ano_letivo')->nullable()
                ->withMeta(['value' => now()->year])
                ->rules('nullable', 'integer', 'min:1901', 'max:2155')
                ->step(1),

                BelongsTo::make('Escola', 'escola', \App\Nova\Escola::class)
                ->sortable()
                ->nullable()
                ->readonly(function ($request) {
                    $pending = \App\Models\TransferRequest::where('matricula_id', $this->id)->where('status', 'pending')->exists();
                    return $pending;
                }),
            Text::make('Nome da Escola', function () {
                return optional($this->escola)->escola_nome;
            })->onlyOnIndex(),



            BelongsTo::make('Turma', 'turmatipo', 'App\Nova\TurmaTipo')->nullable(),


            select::make('irmao na creche', 'irmao_creche')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            select::make('irmao gêmeos', 'irmao_gemeo')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            text::make('nome do irmão gêmeo', 'nome_irmao_gemeo')->nullable(),
            select::make('bolsa familia', 'bolsa_familia')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            select::make('cad unico', 'cad_unico')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            new panel('Identificação do Candidato', $this->id_candidato()),
            new panel('Unidades de Preferencia', $this->unidadeFields()),
            new panel('Dados do responsável', $this->responsavelFields()),
        ];
    }

    public function fieldsForExport(\Laravel\Nova\Http\Requests\NovaRequest $request)
    {
        return [
            Text::make('Data de Inscrição', 'data_inscricao_formatada'),
            Text::make('Idade na Inscrição', function () {
                return $this->data_nascimento ? \Carbon\Carbon::parse($this->data_nascimento)->age : null;
            }),
            Text::make('Nome da Escola', function () {
                return optional($this->escola)->escola_nome ?? '';
            }),
            Text::make('Bairro da Escola', function () {
                return optional($this->bairro_escola)->bairro ?? '';
            }),
            Text::make('Responsável (MAIÚSCULO)', function () {
                return mb_strtoupper($this->nome_responsavel, 'UTF-8');
            }),
            Text::make('Situação', function () {
                // Usa o cadastro de StatusMatricula para trazer o nome correto,
                // em vez de exibir apenas o ID (ex.: 5).
                $status = StatusMatricula::find($this->situacao_matricula);
                return $status ? $status->situacao_matricula : $this->situacao_matricula;
            }),
            Text::make('Data de Nascimento', function () {
                return $this->data_nascimento ? \Carbon\Carbon::parse($this->data_nascimento)->format('d/m/Y') : null;
            }),
            Text::make('Telefone Responsável', function () {
                return $this->tel_cel_responsavel;
            }),
            Text::make('Turma', function () {
                return optional($this->turma)->turma_descricao ?? '';
            }),
        ];
    }

    protected function id_candidato()
    {
        return[
            date::make('data de nascimento da criança', 'data_nascimento')->nullable(),
            number::make('cpf da criança', 'cpf_candidato')->nullable(),
            text::make('idade','idade')->nullable()->hideWhenCreating(),
            text::make('idade_corte_meses','idade_corte_meses')->nullable()->hideWhenCreating(),
            text::make('idade_data_corte','idade_data_corte')->nullable()->hideWhenCreating(),
            text::make('idade_data_corte_mes','idade_data_corte_mes')->nullable()->hideWhenCreating(),
            text::make('idade_data_corte_dias','idade_data_corte_dias')->nullable()->hideWhenCreating(),
            select::make('sexo', 'sexo')->options(['feminino' => 'feminino', 'masculino' => 'masculino', 'outros' => 'outros'])->nullable(),
            select::make('carteira de vacinacao', 'carteira_vacinacao')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            select::make('cartao do sus', 'cartao_sus')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            select::make('portador de deficiencia', 'portador_deficiencia')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            BelongsTo::make('tipo de deficiencia', 'tipo_deficiencia', 'App\Nova\TipoDeficiencia')->nullable(),
        ];
    }

    protected function unidadeFields()
    {
        return[
            belongsTo::make('Bairro', 'bairro_escola', 'App\Nova\Bairro')->nullable(),
            text::make('endereço', 'endereco')->nullable(),
            ];
    }

    protected function responsavelFields()
    {

        return [
            select::make('grau de parentesco', 'grau_parentesco')->options(['Pai' => 'Pai', 'Mãe' => 'Mãe', 'Responsável Legal' => 'Responsável Legal'])->nullable(),
            text::make('nome do responsavel', 'nome_responsavel')->nullable(),
            text::make('email do responsavel', 'email_responsavel')->nullable(),
            date::make('data de nascimento do responsavel', 'data_nasc_responsavel')->nullable(),
            text::make('cpf do responsavel', 'cpf_responsavel')->nullable(),
            text::make('rg do responsavel', 'rg_responsavel')->nullable(),
            select::make('mãe menor de idade', 'mae_menor')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            BelongsTo::make('Escolaridade', 'escolaridade', 'App\Nova\Escolaridade')->nullable(),
            text::make('tel fixo responsavel', 'tel_fixo_responsavel')->nullable(),
            text::make('tel cel responsavel', 'tel_cel_responsavel')->nullable(),
            select::make('vulneravel social', 'vulneravel_social')->options(['Sim' => 'Sim', 'Não' => 'Não'])->nullable(),
            text::make('pedido de transferencia', 'pedido_transferencia')->nullable(),
            text::make('acao judicial do candidato', 'acao_judicial_candidato')->nullable()->hideWhenCreating(),
            text::make('candidato remanescente', 'candidato_remanescente')->nullable()->hideWhenCreating(),
            select::make('inscricao reativada', 'inscricao_reativada')->options(['N' => 'Não', 'S' => 'Sim'])->default('N')->hideWhenCreating(),
            text::make('usr login', 'usr_login')->nullable()->hideWhenCreating(),
            Boolean::make('Declaração', 'declaro'),
            Boolean::make('Edital', 'edital'),
            textarea::make('observação', 'observacao')->nullable(),
        ];
    }


    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new EscolaMatriculaFilter,
            // new TurmaMatriculaFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }



public static function indexQuery(NovaRequest $request, $query)
{
    return $query->whereNotIn('situacao_matricula', [
        13, // Apto para fazer matrícula
        11   // exemplo: Matriculado (troque pelo ID correto)
    ]);
}
    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
   public function actions(NovaRequest $request)
    {
      return [
    (new DownloadExcel)
        ->withHeadings()
        ->only([
            'id',
            'protocolo',
            'nome_candidato',
             'escola',
             'turma_especie',
          'data_nascimento_aluno',
             'data_inscricao_aluno',
              'hora_inscricao',
            'vulneravel_social',
            'portador_deficiencia',
            'escola',
            'cel_responsavel',



        ]),
    new ConfirmarMatricula(),
    new AlterarStatusMatricula(),
];

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

        // Esconde "Turmas" apenas para usuários com papel "colegio"
        if ($user->hasRole('colegio')) {
            return false;
        }

        // Para todos os outros papéis, o recurso aparece normalmente
        return true;
    }

    /**
     * Garante que mesmo acessando a URL direta, o usuário "colegio"
     * não consiga listar esse recurso.
     */
    public static function authorizedToViewAny(Request $request)
    {
        return static::availableForNavigation($request);
    }
}
