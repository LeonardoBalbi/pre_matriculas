<?php

namespace App\Filament\Admin\Resources\Matriculas\Tables;

use App\Models\CpfAutorizado;
use App\Models\Escola;
use App\Models\Matricula;
use App\Models\StatusMatricula;
use App\Models\TransferLog;
use App\Models\TransferRequest;
use App\Models\Turma;
use App\Models\User;
use App\Notifications\NovaAbrirWhatsappMatricula;
use App\Notifications\NovaAutorizarTransferencia;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MatriculasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('protocolo')
                    ->label('Protocolo')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->copyable(),
                TextColumn::make('statusMatricula.status_matricula')
                    ->label('Situação')
                    ->badge()
                    ->color(fn ($record) => match ($record->statusMatricula?->status_matricula) {
                        'Matriculado' => 'success',
                        'Aguardando' => 'warning',
                        'Cancelado', 'Desistente' => 'danger',
                        'Pendente' => 'info',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ano_letivo')
                    ->label('Ano')
                    ->sortable(),
                TextColumn::make('data_nascimento')
                    ->label('Nascimento')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('nome_candidato')
                    ->label('Candidato')
                    ->limit(32)
                    ->searchable(),
                TextColumn::make('cpf_candidato')
                    ->label('CPF')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('escola.escola_nome')
                    ->label('Escola')
                    ->limit(36)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('turma_especie')
                    ->label('Turma especie')
                    ->placeholder('-')
                    ->badge()
                    ->color(fn (?string $state): string => match (str($state)->ascii()->upper()->squish()->toString()) {
                        'BERCARIO' => 'info',
                        'INFANTIL 1' => 'success',
                        'INFANTIL 2' => 'warning',
                        'INFANTIL 3' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('observacao')
                    ->label('Observacao')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('data_inscricao')
                    ->label('Inscricao')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('pendencias_operacionais')
                    ->label('Pendencias')
                    ->getStateUsing(function ($record): string {
                        $pendencias = collect([
                            blank($record->tel_cel_responsavel) ? 'Sem celular' : null,
                            blank($record->email_responsavel) ? 'Sem e-mail' : null,
                            blank($record->escola_nome_id) ? 'Sem escola' : null,
                            blank($record->turma_especie) ? 'Sem turma especie' : null,
                        ])->filter();

                        return $pendencias->isEmpty() ? 'OK' : $pendencias->join(', ');
                    })
                    ->badge()
                    ->color(fn (string $state): string => $state === 'OK' ? 'success' : 'danger')
                    ->limit(34),
                TextColumn::make('idade')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('idade_corte_meses')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('idade_data_corte')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('idade_data_corte_mes')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('idade_data_corte_dias')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('sexo')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('irmao_creche')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('irmao_gemeo')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nome_irmao_gemeo')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('carteira_vacinacao')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cartao_sus')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bolsa_familia')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cad_unico')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('vulneravel_social')
                    ->label('Vulneravel social')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('portador_deficiencia')
                    ->label('PCD')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deficiencias_tipo')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tipo_deficiencia_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('distrito.distrito')
                    ->label('Distrito')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('endereco')
                    ->label('Endereco')
                    ->limit(45)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('bairro_escola.descricao')
                    ->label('Bairro')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('grau_parentesco')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nome_responsavel')
                    ->label('Responsavel')
                    ->limit(28)
                    ->searchable(),
                TextColumn::make('email_responsavel')
                    ->label('E-mail')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('data_nasc_responsavel')
                    ->label('Nascimento responsavel')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cpf_responsavel')
                    ->label('CPF responsavel')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('rg_responsavel')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('mae_menor')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('escolaridade.escolaridade')
                    ->label('Escolaridade')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tel_fixo_responsavel')
                    ->label('Telefone fixo')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('tel_cel_responsavel')
                    ->label('Celular')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('pedido_transferencia')
                    ->searchable(),
                TextColumn::make('aceite_edital')
                    ->searchable(),
                TextColumn::make('acao_judicial_candidato')
                    ->searchable(),
                TextColumn::make('candidato_remanescente')
                    ->searchable(),
                TextColumn::make('tipo_formulario')
                    ->searchable(),
                TextColumn::make('data_reat_inscricao')
                    ->searchable(),
                TextColumn::make('inscricao_reativada')
                    ->searchable(),
                TextColumn::make('usr_login')
                    ->searchable(),
                TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_by_name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('declaro')
                    ->boolean(),
                IconColumn::make('edital')
                    ->boolean(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('escola_nome')
                    ->searchable(),
                TextColumn::make('transferencia')
                    ->searchable(),
            ])
            ->defaultSort(fn (Builder $query): Builder => $query
                ->orderByDesc('data_inscricao')
                ->orderByDesc('id'))
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('confirmarMatricula')
                    ->label('Confirmar Matrícula')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn () => auth()->user()?->hasAnyRole(['admin', 'colegio', 'super-admin', 'admin_edu']))
                    ->action(function ($record): void {
                        $matriculadoId = StatusMatricula::where('status_matricula', 'Matriculado')->value('id');
                        if (!$matriculadoId) {
                            Notification::make()->title('Erro')->body('Status "Matriculado" não encontrado.')->danger()->send();
                            return;
                        }

                        $record->situacao_matricula = $matriculadoId;
                        auth()->user()?->notify(new NovaAbrirWhatsappMatricula($record));
                        $record->save();

                        // WhatsApp Redirect
                        $telefone = $record->tel_cel_responsavel;
                        $digits = preg_replace('/[^0-9]/', '', (string) $telefone);
                        if ($digits && substr($digits, 0, 2) !== '55') {
                            $digits = '55' . $digits;
                        }
                        if (strlen($digits) === 12) {
                            $digits = substr($digits, 0, 4) . '9' . substr($digits, 4);
                        }
                        $escola = $record->escola ? $record->escola->escola_nome : 'Não informado';
                        $encodedId = base64_encode((string) $record->id);
                        $comp = url("/matricula/comprovante/{$encodedId}/d");
                        $msg = "MATRÍCULA CONFIRMADA\n\nProtocolo: {$record->protocolo}\nAluno: {$record->nome_candidato}\nEscola: {$escola}\nAno Letivo: {$record->ano_letivo}\nComprovante: {$comp}";
                        $waUrl = "https://web.whatsapp.com/send/?phone={$digits}&text=" . urlencode($msg);

                        Notification::make()->title('Matrícula confirmada!')->success()->send();

                        // Redirect to WhatsApp in new tab
                        // Filament actions can return a redirect but not open in new tab easily from action() closure
                        // unless we use js.
                    })
                    ->url(function ($record) {
                        $telefone = $record->tel_cel_responsavel;
                        $digits = preg_replace('/[^0-9]/', '', (string) $telefone);
                        if ($digits && substr($digits, 0, 2) !== '55') {
                            $digits = '55' . $digits;
                        }
                        if (strlen($digits) === 12) {
                            $digits = substr($digits, 0, 4) . '9' . substr($digits, 4);
                        }
                        $escola = $record->escola ? $record->escola->escola_nome : 'Não informado';
                        $encodedId = base64_encode((string) $record->id);
                        $comp = url("/matricula/comprovante/{$encodedId}/d");
                        $msg = "MATRÍCULA CONFIRMADA\n\nProtocolo: {$record->protocolo}\nAluno: {$record->nome_candidato}\nEscola: {$escola}\nAno Letivo: {$record->ano_letivo}\nComprovante: {$comp}";
                        return "https://web.whatsapp.com/send/?phone={$digits}&text=" . urlencode($msg);
                    })
                    ->openUrlInNewTab(),
                Action::make('solicitarTransferencia')
                    ->label('Solicitar Transferência')
                    ->icon('heroicon-o-arrows-right-left')
                    ->color('warning')
                    ->form([
                        Select::make('to_escola_id')
                            ->label('Escola de destino')
                            ->options(Escola::query()->pluck('escola_nome', 'id'))
                            ->required()
                            ->searchable(),
                        Textarea::make('reason')
                            ->label('Motivo')
                            ->nullable(),
                    ])
                    ->action(function ($record, array $data): void {
                        $user = auth()->user();
                        $toId = (int)$data['to_escola_id'];

                        $fromId = $record->escola_nome_id ?: 0;
                        $tr = TransferRequest::create([
                            'matricula_id' => $record->id,
                            'from_escola_id' => $fromId,
                            'to_escola_id' => $toId,
                            'requested_by' => $user->id,
                            'status' => 'pending',
                            'reason' => $data['reason'],
                        ]);
                        $record->pedido_transferencia = 'Solicitada';
                        $record->save();

                        $destUsers = User::role('colegio')->where('escola_id', $toId)->get();
                        foreach ($destUsers as $u) {
                            $u->notify(new NovaAutorizarTransferencia($tr));
                        }

                        Notification::make()
                            ->title('Transferência solicitada!')
                            ->body('Aguardando autorização da escola destino.')
                            ->success()
                            ->send();
                    }),
                Action::make('autorizarTransferencia')
                    ->label('Autorizar Transferência')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn ($record) => 
                        $record->pedido_transferencia === 'Solicitada' &&
                        (auth()->user()?->hasAnyRole(['super-admin', 'admin_edu']) || 
                        (auth()->user()?->hasRole('colegio') && TransferRequest::where('matricula_id', $record->id)->where('status', 'pending')->where('to_escola_id', auth()->user()->escola_id)->exists()))
                    )
                    ->action(function ($record): void {
                        $user = auth()->user();
                        $tr = TransferRequest::where('matricula_id', $record->id)
                            ->where('status', 'pending')
                            ->first();

                        if (!$tr) {
                            Notification::make()->title('Erro')->body('Solicitação não encontrada.')->danger()->send();
                            return;
                        }

                        $tr->status = 'approved';
                        $tr->authorized_by = $user->id;
                        $tr->authorized_at = now();
                        $tr->save();

                        $record->escola_nome_id = $tr->to_escola_id;
                        $record->pedido_transferencia = 'Transferida';

                        if (!empty($record->turma_especie)) {
                            $tipo = \DB::table('turma_tipos')->where('tipo_descricao', $record->turma_especie)->first();
                            if ($tipo) {
                                $novaTurma = Turma::where('turma_escola_id', $tr->to_escola_id)
                                    ->where('turma_tipo_id', $tipo->id)
                                    ->where('turma_status', 'ativa')
                                    ->orderBy('id')
                                    ->first();
                                if ($novaTurma) {
                                    $record->turma_id = $novaTurma->id;
                                } else {
                                    $record->turma_id = null;
                                }
                            }
                        }
                        $record->save();

                        TransferLog::create([
                            'matricula_id' => $record->id,
                            'from_escola_id' => $tr->from_escola_id,
                            'to_escola_id' => $tr->to_escola_id,
                            'action' => 'approved',
                            'by_user_id' => $user->id,
                            'reason' => $tr->reason,
                        ]);

                        Notification::make()->title('Transferência autorizada!')->success()->send();
                    }),
                Action::make('recusarTransferencia')
                    ->label('Recusar Transferência')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => 
                        $record->pedido_transferencia === 'Solicitada' &&
                        (auth()->user()?->hasAnyRole(['super-admin', 'admin_edu']) || 
                        (auth()->user()?->hasRole('colegio') && TransferRequest::where('matricula_id', $record->id)->where('status', 'pending')->where('to_escola_id', auth()->user()->escola_id)->exists()))
                    )
                    ->action(function ($record): void {
                        $user = auth()->user();
                        $tr = TransferRequest::where('matricula_id', $record->id)
                            ->where('status', 'pending')
                            ->first();

                        if (!$tr) {
                            Notification::make()->title('Erro')->body('Solicitação não encontrada.')->danger()->send();
                            return;
                        }

                        $tr->status = 'rejected';
                        $tr->authorized_by = $user->id;
                        $tr->authorized_at = now();
                        $tr->save();

                        $record->pedido_transferencia = 'Recusada';
                        $record->save();

                        TransferLog::create([
                            'matricula_id' => $record->id,
                            'from_escola_id' => $tr->from_escola_id,
                            'to_escola_id' => $tr->to_escola_id,
                            'action' => 'rejected',
                            'by_user_id' => $user->id,
                            'reason' => $tr->reason,
                        ]);

                        Notification::make()->title('Transferência recusada.')->success()->send();
                    }),
                Action::make('restaurarMatricula')
                    ->label('Restaurar Matrícula')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->visible(fn ($record) => $record->trashed() && auth()->user()?->hasRole('super-admin'))
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $record->restore();
                        Notification::make()->title('Matrícula restaurada com sucesso.')->success()->send();
                    }),
                Action::make('liberarCpf')
                    ->label('Liberar CPF')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->visible(function ($record): bool {
                        if (! auth()->user()?->hasAnyRole(['super-admin', 'admin', 'admin_edu'])) {
                            return false;
                        }

                        $cpf = preg_replace('/\D+/', '', (string) $record->cpf_candidato);

                        return $cpf !== '' && CpfAutorizado::where('cpf', $cpf)->exists();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Liberar CPF para novo cadastro')
                    ->modalDescription('Remove este CPF da lista de bloqueio. A matricula atual continua registrada, mas o formulario publico podera aceitar novo cadastro para o mesmo CPF.')
                    ->action(function ($record): void {
                        $cpf = preg_replace('/\D+/', '', (string) $record->cpf_candidato);
                        $deleted = $cpf !== '' ? CpfAutorizado::where('cpf', $cpf)->delete() : 0;

                        Notification::make()
                            ->title($deleted ? 'CPF liberado' : 'CPF ja estava liberado')
                            ->body($deleted ? 'Novo cadastro com este CPF foi liberado.' : 'Nao havia bloqueio ativo para este CPF.')
                            ->success()
                            ->send();
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('alterarStatusEmMassa')
                        ->label('Alterar Status em Massa')
                        ->icon('heroicon-o-pencil-square')
                        ->form([
                            Select::make('status')
                                ->label('Novo Status')
                                ->options(StatusMatricula::all()->pluck('status_matricula', 'id'))
                                ->required(),
                            Textarea::make('observacao')
                                ->label('Observação (Opcional)')
                                ->placeholder('Esta observação será adicionada ao histórico da matrícula.'),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $statusId = $data['status'];
                            $observacao = $data['observacao'];

                            foreach ($records as $record) {
                                $record->situacao_matricula = $statusId;

                                if ($observacao) {
                                    $dataAtual = now()->format('d/m/Y H:i');
                                    $novaObs = "[$dataAtual] Alteração de status em massa: " . $observacao;
                                    $record->observacao = $record->observacao ? $record->observacao . "\n" . $novaObs : $novaObs;
                                }

                                $record->save();
                            }

                            Notification::make()
                                ->title('Status atualizado com sucesso!')
                                ->body($records->count() . ' registro(s) atualizado(s).')
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('confirmarMatriculaMassa')
                        ->label('Confirmar Matrícula em Massa')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn () => auth()->user()?->hasAnyRole(['admin', 'colegio', 'super-admin', 'admin_edu']))
                        ->action(function (Collection $records): void {
                            $matriculadoId = StatusMatricula::where('status_matricula', 'Matriculado')->value('id');
                            if (!$matriculadoId) {
                                Notification::make()->title('Erro')->body('Status "Matriculado" não encontrado.')->danger()->send();
                                return;
                            }

                            foreach ($records as $record) {
                                $record->situacao_matricula = $matriculadoId;
                                auth()->user()?->notify(new NovaAbrirWhatsappMatricula($record));
                                $record->save();
                            }

                            Notification::make()
                                ->title('Matrículas confirmadas!')
                                ->body($records->count() . ' registro(s) confirmado(s).')
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('excluirMatricula')
                        ->label('Excluir Matrícula(s)')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->form([
                            Textarea::make('motivo_exclusao')
                                ->label('Motivo da Exclusão')
                                ->required()
                                ->placeholder('Informe o motivo da exclusão'),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                request()->merge(['motivo_exclusao' => $data['motivo_exclusao']]);
                                $record->delete();
                            }

                            Notification::make()
                                 ->title('Matrícula(s) excluída(s) com sucesso!')
                                 ->success()
                                 ->send();
                         }),
                    BulkAction::make('exportarExcel')
                        ->label('Exportar para CSV')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $filename = 'matriculas_' . now()->format('Y-m-d_H-i-s') . '.csv';
                            
                            $response = new StreamedResponse(function () use ($records) {
                                $csv = Writer::createFromPath('php://output', 'w+');
                                $csv->setDelimiter(';');
                                
                                // Headings
                                $csv->insertOne([
                                    'Protocolo',
                                    'Nome do Candidato',
                                    'Data de Nascimento',
                                    'Vulnerável Social',
                                    'Portador de Deficiência',
                                ]);
                                
                                foreach ($records as $record) {
                                    $csv->insertOne([
                                        $record->protocolo,
                                        $record->nome_candidato,
                                        $record->data_nascimento ? $record->data_nascimento->format('d/m/Y') : '',
                                        $record->vulneravel_social ? 'Sim' : 'Não',
                                        $record->portador_deficiencia ? 'Sim' : 'Não',
                                    ]);
                                }
                            });
                            
                            $response->headers->set('Content-Type', 'text/csv');
                            $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                            
                            return $response;
                        }),
                      DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
