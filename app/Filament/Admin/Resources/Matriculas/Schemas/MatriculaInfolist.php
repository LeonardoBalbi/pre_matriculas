<?php

namespace App\Filament\Admin\Resources\Matriculas\Schemas;

use App\Models\Matricula;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MatriculaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('protocolo')
                    ->numeric(),
                TextEntry::make('situacao_matricula_nome')
                    ->label('Situacao matricula')
                    ->placeholder('-'),
                TextEntry::make('ano_letivo')
                    ->placeholder('-'),
                TextEntry::make('data_nascimento')
                    ->placeholder('-'),
                TextEntry::make('nome_candidato')
                    ->placeholder('-'),
                TextEntry::make('cpf_candidato'),
                TextEntry::make('escola_nome_display')
                    ->label('Escola')
                    ->placeholder('-'),
                TextEntry::make('turma_especie')
                    ->label('Turma especie')
                    ->badge()
                    ->color(fn (?string $state): string => match (str($state)->ascii()->upper()->squish()->toString()) {
                        'BERCARIO' => 'info',
                        'INFANTIL 1' => 'success',
                        'INFANTIL 2' => 'warning',
                        'INFANTIL 3' => 'danger',
                        default => 'gray',
                    })
                    ->placeholder('-'),
                TextEntry::make('observacao')
                    ->placeholder('-'),
                TextEntry::make('data_inscricao')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('idade')
                    ->placeholder('-'),
                TextEntry::make('idade_corte_meses')
                    ->placeholder('-'),
                TextEntry::make('idade_data_corte')
                    ->placeholder('-'),
                TextEntry::make('idade_data_corte_mes')
                    ->placeholder('-'),
                TextEntry::make('idade_data_corte_dias')
                    ->placeholder('-'),
                TextEntry::make('sexo')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('irmao_creche')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('irmao_gemeo')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('nome_irmao_gemeo')
                    ->placeholder('-'),
                TextEntry::make('carteira_vacinacao')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('cartao_sus')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('bolsa_familia')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('cad_unico')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('vulneravel_social')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('portador_deficiencia')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('deficiencias_tipo')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('tipo_deficiencia_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('distrito_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('endereco')
                    ->placeholder('-'),
                TextEntry::make('escola_bairro_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('grau_parentesco')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('nome_responsavel')
                    ->placeholder('-'),
                TextEntry::make('email_responsavel')
                    ->placeholder('-'),
                TextEntry::make('data_nasc_responsavel')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('cpf_responsavel')
                    ->placeholder('-'),
                TextEntry::make('rg_responsavel')
                    ->placeholder('-'),
                TextEntry::make('mae_menor')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('escolaridade_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('tel_fixo_responsavel')
                    ->placeholder('-'),
                TextEntry::make('tel_cel_responsavel')
                    ->placeholder('-'),
                TextEntry::make('pedido_transferencia')
                    ->placeholder('-'),
                TextEntry::make('aceite_edital'),
                TextEntry::make('acao_judicial_candidato')
                    ->placeholder('-'),
                TextEntry::make('candidato_remanescente')
                    ->placeholder('-'),
                TextEntry::make('tipo_formulario')
                    ->placeholder('-'),
                TextEntry::make('data_reat_inscricao')
                    ->placeholder('-'),
                TextEntry::make('inscricao_reativada')
                    ->placeholder('-'),
                TextEntry::make('usr_login')
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by_name')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('declaro')
                    ->boolean(),
                IconEntry::make('edital')
                    ->boolean(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Matricula $record): bool => $record->trashed()),
                TextEntry::make('escola_nome')
                    ->placeholder('-'),
                TextEntry::make('transferencia')
                    ->placeholder('-'),
            ]);
    }
}
