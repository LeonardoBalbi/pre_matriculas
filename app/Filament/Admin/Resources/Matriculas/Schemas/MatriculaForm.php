<?php

namespace App\Filament\Admin\Resources\Matriculas\Schemas;

use App\Models\Escola;
use App\Models\StatusMatricula;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MatriculaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('protocolo')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('situacao_matricula')
                    ->label('Situacao matricula')
                    ->options(fn (): array => StatusMatricula::query()
                        ->whereNotNull('status_matricula')
                        ->where('status_matricula', '<>', '')
                        ->orderBy('status_matricula')
                        ->pluck('status_matricula', 'id')
                        ->all())
                    ->getSearchResultsUsing(fn (?string $search): array => StatusMatricula::query()
                        ->whereNotNull('status_matricula')
                        ->where('status_matricula', '<>', '')
                        ->when($search, fn ($query) => $query->where('status_matricula', 'like', "%{$search}%"))
                        ->orderBy('status_matricula')
                        ->limit(50)
                        ->pluck('status_matricula', 'id')
                        ->all())
                    ->getOptionLabelUsing(fn ($value): ?string => filled($value)
                        ? (StatusMatricula::whereKey($value)->value('status_matricula') ?? 'Status nao encontrado')
                        : null)
                    ->searchable()
                    ->native(false)
                    ->preload()
                    ->nullable(),
                TextInput::make('ano_letivo'),
                TextInput::make('data_nascimento'),
                TextInput::make('nome_candidato'),
                TextInput::make('cpf_candidato')
                    ->required(),
                Select::make('escola_nome_id')
                    ->label('Escola')
                    ->options(fn (): array => Escola::query()
                        ->whereNotNull('escola_nome')
                        ->where('escola_nome', '<>', '')
                        ->orderBy('escola_nome')
                        ->pluck('escola_nome', 'id')
                        ->all())
                    ->getSearchResultsUsing(fn (?string $search): array => Escola::query()
                        ->whereNotNull('escola_nome')
                        ->where('escola_nome', '<>', '')
                        ->when($search, fn ($query) => $query->where('escola_nome', 'like', "%{$search}%"))
                        ->orderBy('escola_nome')
                        ->limit(50)
                        ->pluck('escola_nome', 'id')
                        ->all())
                    ->getOptionLabelUsing(fn ($value): ?string => filled($value)
                        ? (Escola::whereKey($value)->value('escola_nome') ?? 'Escola nao encontrada')
                        : null)
                    ->searchable()
                    ->native(false)
                    ->preload()
                    ->nullable(),
                TextInput::make('turma_especie')
                    ->label('Turma especie'),
                TextInput::make('observacao'),
                DateTimePicker::make('data_inscricao'),
                TextInput::make('idade'),
                TextInput::make('idade_corte_meses'),
                TextInput::make('idade_data_corte'),
                TextInput::make('idade_data_corte_mes'),
                TextInput::make('idade_data_corte_dias'),
                Select::make('sexo')
                    ->options(['feminino' => 'Feminino', 'masculino' => 'Masculino', 'outros' => 'Outros']),
                Select::make('irmao_creche')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                Select::make('irmao_gemeo')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                TextInput::make('nome_irmao_gemeo'),
                Select::make('carteira_vacinacao')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                Select::make('cartao_sus')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                Select::make('bolsa_familia')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                Select::make('cad_unico')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                Select::make('vulneravel_social')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                Select::make('portador_deficiencia')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                TextInput::make('deficiencias_tipo')
                    ->numeric(),
                TextInput::make('tipo_deficiencia_id')
                    ->numeric(),
                TextInput::make('distrito_id')
                    ->numeric(),
                TextInput::make('endereco'),
                TextInput::make('escola_bairro_id')
                    ->numeric(),
                Select::make('grau_parentesco')
                    ->options(['pai' => 'Pai', 'mãe' => 'Mãe', 'responsável legal' => 'Responsável legal']),
                TextInput::make('nome_responsavel'),
                TextInput::make('email_responsavel')
                    ->email(),
                DatePicker::make('data_nasc_responsavel'),
                TextInput::make('cpf_responsavel'),
                TextInput::make('rg_responsavel'),
                Select::make('mae_menor')
                    ->options(['sim' => 'Sim', 'não' => 'Não']),
                TextInput::make('escolaridade_id')
                    ->numeric(),
                TextInput::make('tel_fixo_responsavel')
                    ->tel(),
                TextInput::make('tel_cel_responsavel')
                    ->tel(),
                TextInput::make('pedido_transferencia'),
                TextInput::make('aceite_edital')
                    ->required()
                    ->default('s'),
                TextInput::make('acao_judicial_candidato'),
                TextInput::make('candidato_remanescente'),
                TextInput::make('tipo_formulario'),
                TextInput::make('data_reat_inscricao'),
                TextInput::make('inscricao_reativada'),
                TextInput::make('usr_login'),
                TextInput::make('updated_by')
                    ->numeric(),
                TextInput::make('updated_by_name'),
                Toggle::make('declaro')
                    ->required(),
                Toggle::make('edital')
                    ->required(),
                TextInput::make('escola_nome'),
                TextInput::make('transferencia'),
            ]);
    }
}
