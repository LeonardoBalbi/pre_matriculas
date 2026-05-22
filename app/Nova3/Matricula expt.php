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
use Illuminate\View\AnonymousComponent;

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
        return 'Matrículas';
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
                'BERÇÁRIO A' => 'BERÇÁRIO A',
                'BERÇÁRIO B' => 'BERÇÁRIO B',
                'Nível 1' => 'Nível 1',
                'Nível 2' => 'Nível 2',
                'Não atribuída' => 'Não atribuída',
            ])
            ->colors([
                'BERÇÁRIO A' => 'blue',
                'BERÇÁRIO B' => 'cyan',
                'Nível 1' => 'green',
                'Nível 2' => 'orange',
                'Não atribuída' => 'gray',
            ])

            ->showOnIndex()
            ->showOnDetail()
            ->showOnCreating()
            ->showOnUpdating(),
            Badge::make('Status', 'situacao_matricula')
            ->options($mat_cor_status)
            ->colors($mat_cor_op)->displayUsingLabels(),
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
                ->nullable(),
            // Text::make('Nome da Escola', function () {
            //     return optional($this->escola)->escola_nome;
            // })->onlyOnIndex(),



            // belongsTo::make('turma', 'turmatipo', 'App\Nova\TurmaTipo')->nullable(),

            // BelongsTo::make('Turma')->nullable(),
            // BelongsTo::make('Turma')
            // ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
            //     Log::info("Current: ".  $request->current);
            //     Log::info("ID Atual: ".  $request->resourceId);
            //     Log::info($request);
            //     if($request->current == null && $request->resourceId == null){
            //         return $query->where('turma_escola_id', 1);
            //     }
            //     if ($request->current) {
            //         $escolaId = Turma::find($request->current)->turma_escola_id;
            //         return $query->where('turma_escola_id', $escolaId);

            //     }else{
            //         // $turma = ModelsMatricula::find($request->resourceId)->escola_nome_id;
            //         // $escolaId = Turma::find($turma)->turma_escola_id;
            //         // return $query->where('turma_escola_id', $escolaId);
            //     }

            // }),


            // Text::make('Tipo da Turma', function () {
            //     return $this->turma ? $this->turma->turmatipo->tipo_descricao : '';
            // })->exceptOnForms(),

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
                return $this->situacao_matricula == 'aguardando' ? 'Aguardando' : ucfirst($this->situacao_matricula);
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
            ->except([
                'cpf_candidato',
                'idade',
                'situacao_matricula',
                'observacao',
                'idade_corte_meses',

                'nome_escola',
                'escola_nome_id',
                'ano_letivo',
                'turma_id',
                'sexo',
                'idade',
                'situacao_matricula',
                'observacao',
                'idade_corte_mes',
                'idade_data_corte',
                'ano_letivo',
                'turma_id',
                'sexo',
                'irmao_creche',
                'irmao_gemeo',
                'nome_irmao_gemeo',
                'turma_id',
                'carteira_vacinacao',
                'cartao_sus',
                'bolsa_familia',
                'cad_unico',
                'portador_deficiencia',
                'deficiencias_tipo',
                'distrito_id',
                'endereco',
                'nome_responsavel',
                'email_responsavel',
                'data_nasc_responsavel',
                'cpf_responsavel',
                'rg_responsavel',
                'mae_menor',
                'bairro_escola_nome',
                'bairro_escola',
                'endereco',
                'escolaridade_id',
                'pedido_transferencia',
                'tipo_deficiencia',
                'aceite_edital',
                'acao_judicial_candidato',
                'candidato_remanescente',
                'data_inscricao',
                'data_reat_inscricao',
                'inscricao_reativada',
                'usr_login',
                'telefone_responsavel',
                'tel_fixo_responsavel',
                'tel_cel_responsavel',
                'email_responsavel',
                'grau_parentesco',
                'nome_responsavel',
                'data_nasc_responsavel',
                'cpf_responsavel',
                'rg_responsavel',
                'mae_menor',
                'escolaridade',
                'bairro',
                'idade_data_corte_dias',
                'pedido_transferencia',
                'deficiencias_tipo',
                'idade_data_corte_mes',
                 'aceite_edital',
                'declaro',
                'edital',
                'turma_especie',
            ]),
    ];
}

}
