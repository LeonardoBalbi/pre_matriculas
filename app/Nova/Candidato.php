<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\HasMany;
use Timothyasp\Badge\Badge;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Rhyltonn\SomaPontosFields\SomaPontosFields;


class Candidato extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Candidato>
     */
    public static $model = \App\Models\Candidato::class;
    public static $displayInNavigation = true;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'nome';



    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'nome', 'cpf', 'email', 'celular',
    ];

public static function availableForNavigation(Request $request)
{
    $user = $request->user();

    return !(
        $user &&
        method_exists($user, 'hasRole') &&
        (
            $user->hasRole('admin_edu') ||
            $user->hasRole('colegio')
        )
    );
}
    public static function authorizedToViewAny(Request $request)
    {
        return static::availableForNavigation($request);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {

        $status = [
            'aguardando' => 'Aguardando',
            'Em análise' => 'Aguardando',
            'selecionado' => 'Selecionado',
            'reprovado' => 'Reprovado',
        ];

        return [
            ID::make()->sortable(),

            Badge::make('Status', 'status')->options($status)
            ->colors([
               'selecionado' => '#15B750',
               'aguardando' => '#E8F615',
               'Em análise' => '#E8F615',
               'reprovado' => '#EF2D13',

            ]),

            BelongsTo::make('Vaga', 'vagas', Vagas::class)
                ->sortable()
                ->rules('required')
                ->viewable(false),

            Text::make('Nome')
            ->sortable()
            ->rules('required', 'max:255'),

            Select::make('Local Pretendido', 'local')->options([
                'mangaratiba' => '1º Distrito: Mangaratiba, Ibicuí, Praia Brava, Junqueira, Praia do Saco, Acampamento, Fazenda Ingaíba e Batatal',
                'conceicao de jacarei' => '2º Distrito: Conceição de Jacareí',
                'itacuruca' => '3º Distrito: Itacuruçá',
                'muriqui' => '4º Distrito: Muriqui',
                'serra do piloto' => '5º Distrito: Serra do Piloto',
            ])->displayUsingLabels(),


            Number::make('Pontuação', 'pontos')->step(0.01)
            ->sortable(),

            // SomaPontosFields::make('Pontuação', 'pontos')
            //     ->withCalculo($this->id),


            Text::make('CPF')
                ->sortable()
                ->rules('required', 'max:14'),

            Date::make('Data de Nascimento', 'data_nasc')
                ->sortable()
                ->rules('required', 'date'),

            Select::make('Cor/Raça', 'cor_raca')->options([
                'branca' => 'Branca',
                'preta' => 'Preta',
                'parda' => 'Parda',
                'amarela' => 'Amarela',
                'indigena' => 'Indígena',
            ])->displayUsingLabels(),

            Text::make('Nacionalidade', 'nacionalidade')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Naturalidade',  'naturalidade')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Sexo', 'sexo')->options([
                'Feminino' => 'Feminino',
                'Masculino' => 'Masculino',
                'Outro' => 'Outro',
            ])->displayUsingLabels(),

            Select::make('Estado Civil', 'estado_civil')->options([
                'solteiro' => 'Solteiro(a)',
                'casado' => 'Casado(a)',
                'separado' => 'Separado(a)',
                'divorciado' => 'Divorciado(a)',
                'viuvo' => 'Viúvo(a)',
            ])->displayUsingLabels(),

            Boolean::make('Possui Deficiência?', 'deficiencia')
                // ->displayUsingLabels()
                ->nullable(),

            Text::make('Tipo de Deficiência', 'tipo_deficiencia')
                ->sortable()
                ->nullable(),

            Text::make('Nome do Pai', 'nome_pai')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Nome da Mãe', 'nome_mae')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Escolaridade', 'escolaridade')->options([
                'fundamental_incompleto' => 'Fundamental Incompleto',
                'fundamental_completo' => 'Fundamental Completo',
                'medio_incompleto' => 'Médio Incompleto',
                'medio_completo' => 'Médio Completo',
                'superior_incompleto' => 'Superior Incompleto',
                'superior_completo' => 'Superior Completo',
            ])->displayUsingLabels(),

            Text::make('RG', 'rg')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Text::make('Órgão Emissor', 'rg_emissor')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Text::make('Estado Emissor', 'rg_estado')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Date::make('Data de Emissão', 'rg_data_emissao')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Text::make('CEP', 'cep')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Text::make('Endereço', 'endereco')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Number::make('Número', 'numero')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Text::make('Complemento', 'complemento')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Text::make('Bairro', 'bairro')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Text::make('Cidade', 'cidade')
                ->hideFromIndex()
                ->sortable()
                ->nullable(),

            Select::make('UF', 'uf')
                ->options([
                    'AC' => 'Acre',
                    'AL' => 'Alagoas',
                    'AP' => 'Amapá',
                    'AM' => 'Amazonas',
                    'BA' => 'Bahia',
                    'CE' => 'Ceará',
                    'DF' => 'Distrito Federal',
                    'ES' => 'Espírito Santo',
                    'GO' => 'Goiás',
                    'MA' => 'Maranhão',
                    'MT' => 'Mato Grosso',
                    'MS' => 'Mato Grosso do Sul',
                    'MG' => 'Minas Gerais',
                    'PA' => 'Pará',
                    'PB' => 'Paraíba',
                    'PR' => 'Paraná',
                    'PE' => 'Pernambuco',
                    'PI' => 'Piauí',
                    'RJ' => 'Rio de Janeiro',
                    'RN' => 'Rio Grande do Norte',
                    'RS' => 'Rio Grande do Sul',
                    'RO' => 'Rondônia',
                    'RR' => 'Roraima',
                    'SC' => 'Santa Catarina',
                    'SP' => 'São Paulo',
                    'SE' => 'Sergipe',
                    'TO' => 'Tocantins',
                ])
                ->displayUsingLabels()
                ->nullable(),

            // Text::make('Telefone', 'telefone')
            //     ->hideFromIndex()
            //     ->sortable()
            //     ->nullable(),

            Text::make('Celular', 'celular')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:20'),

            Email::make('E-mail', 'email')
                ->sortable()
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:candidatos,email'),


            HasMany::make('Experiência', 'getCanditadoXp', 'App\Nova\CandidatoXp'),

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
            new Filters\VagaFilter,
            new Filters\CorRacaFilter,
            new Filters\DeficienciaFilter,
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
            new DownloadExcel,
        ];
    }
}
