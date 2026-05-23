<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\Matriculas\MatriculaResource;
use App\Models\Matricula;
use App\Models\StatusMatricula;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class MatriculasNovasOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Central de notificacoes';

    protected ?string $description = 'Acompanhe novas inscricoes e pendencias recentes da pre-matricula.';

    protected ?string $pollingInterval = '15s';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $emAnaliseId = $this->statusIdLike('Em an%lise');
        $matriculadoId = $this->statusId('Matriculado');

        $hoje = Matricula::query()
            ->whereDate('created_at', today())
            ->count();

        $emAnalise = Matricula::query()
            ->when(
                $emAnaliseId,
                fn (Builder $query): Builder => $query->where('situacao_matricula', $emAnaliseId),
                fn (Builder $query): Builder => $query->whereRaw('1 = 0'),
            )
            ->count();

        $ultimas24h = Matricula::query()
            ->where('created_at', '>=', now()->subDay())
            ->count();

        $matriculadosHoje = Matricula::query()
            ->when(
                $matriculadoId,
                fn (Builder $query): Builder => $query->where('situacao_matricula', $matriculadoId),
                fn (Builder $query): Builder => $query->whereRaw('1 = 0'),
            )
            ->whereDate('updated_at', today())
            ->count();

        return [
            Stat::make('Novas hoje', $hoje)
                ->description($hoje > 0 ? 'Clique para abrir a listagem' : 'Nenhuma inscricao nova hoje')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color($hoje > 0 ? 'warning' : 'gray')
                ->icon('heroicon-o-bell-alert')
                ->url(MatriculaResource::getUrl('index')),

            Stat::make('Em analise', $emAnalise)
                ->description('Fila principal da secretaria')
                ->descriptionIcon('heroicon-m-clock')
                ->color($emAnalise > 0 ? 'info' : 'gray')
                ->icon('heroicon-o-clipboard-document-list')
                ->url(MatriculaResource::getUrl('index')),

            Stat::make('Ultimas 24h', $ultimas24h)
                ->description('Entradas recentes no sistema')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($ultimas24h > 0 ? 'success' : 'gray')
                ->icon('heroicon-o-sparkles')
                ->url(MatriculaResource::getUrl('index')),

            Stat::make('Confirmadas hoje', $matriculadosHoje)
                ->description('Matriculas efetivadas hoje')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($matriculadosHoje > 0 ? 'success' : 'gray')
                ->icon('heroicon-o-check-circle')
                ->url(MatriculaResource::getUrl('index')),
        ];
    }

    protected function statusId(string $status): ?int
    {
        return StatusMatricula::query()
            ->where('status_matricula', $status)
            ->value('id');
    }

    protected function statusIdLike(string $status): ?int
    {
        return StatusMatricula::query()
            ->where('status_matricula', 'like', $status)
            ->value('id');
    }
}
