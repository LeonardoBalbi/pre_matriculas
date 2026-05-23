<?php

namespace App\Filament\Admin\Resources\Matriculas\Pages;

use App\Filament\Admin\Resources\Matriculas\MatriculaResource;
use App\Models\Matricula;
use App\Models\StatusMatricula;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMatriculas extends ListRecords
{
    protected static string $resource = MatriculaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'em_analise';
    }

    public function getTabs(): array
    {
        $emAnaliseId = $this->statusIdLike('Em an%lise');
        $matriculadoId = $this->statusId('Matriculado');
        $cadastroReservaId = $this->statusId('Cadastro de reserva');
        $organizadosIds = collect([$emAnaliseId, $matriculadoId, $cadastroReservaId])
            ->filter()
            ->values()
            ->all();

        return [
            'em_analise' => Tab::make('Em análise')
                ->badge($this->countByStatusId($emAnaliseId))
                ->query(fn (Builder $query): Builder => $this->whereStatus($query, $emAnaliseId)),

            'matriculados' => Tab::make('Matriculados')
                ->badge($this->countByStatusId($matriculadoId))
                ->query(fn (Builder $query): Builder => $this->whereStatus($query, $matriculadoId)),

            'cadastro_reserva' => Tab::make('Cadastro de reserva')
                ->badge($this->countByStatusId($cadastroReservaId))
                ->query(fn (Builder $query): Builder => $this->whereStatus($query, $cadastroReservaId)),

            'outros' => Tab::make('Outros status')
                ->badge($this->countOutrosStatus($organizadosIds))
                ->query(fn (Builder $query): Builder => $query->whereNotIn('situacao_matricula', $organizadosIds)),

            'todos' => Tab::make('Todos')
                ->badge(Matricula::query()->count()),
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

    protected function whereStatus(Builder $query, ?int $statusId): Builder
    {
        if (! $statusId) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('situacao_matricula', $statusId);
    }

    protected function countByStatusId(?int $statusId): int
    {
        if (! $statusId) {
            return 0;
        }

        return Matricula::query()
            ->where('situacao_matricula', $statusId)
            ->count();
    }

    protected function countOutrosStatus(array $statusIds): int
    {
        return Matricula::query()
            ->when(
                filled($statusIds),
                fn (Builder $query): Builder => $query->whereNotIn('situacao_matricula', $statusIds),
            )
            ->count();
    }
}
