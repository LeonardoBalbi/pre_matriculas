<?php

namespace App\Filament\Admin\Resources\Matriculas\Schemas;

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
                TextInput::make('situacao_matricula')
                    ->numeric(),
                TextInput::make('ano_letivo'),
                TextInput::make('data_nascimento'),
                TextInput::make('nome_candidato'),
                TextInput::make('cpf_candidato')
                    ->required(),
                TextInput::make('escola_nome_id')
                    ->numeric(),
                TextInput::make('turma_id')
                    ->numeric(),
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
                TextInput::make('turma_especie'),
                TextInput::make('escola_nome'),
                TextInput::make('transferencia'),
            ]);
    }
}
