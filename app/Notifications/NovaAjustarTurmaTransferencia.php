<?php

namespace App\Notifications;

use App\Models\Matricula;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NovaAjustarTurmaTransferencia extends Notification
{
    use Queueable;

    protected Matricula $matricula;

    protected int $escolaId;

    public function __construct(Matricula $matricula, int $escolaId)
    {
        $this->matricula = $matricula;
        $this->escolaId = $escolaId;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $url = url("/admin/escolas/{$this->escolaId}/edit");

        return FilamentNotification::make()
            ->title('Ajustar turma da transferencia')
            ->body("Transferencia concluida sem turma para {$this->matricula->nome_candidato}.")
            ->icon('heroicon-o-exclamation-triangle')
            ->warning()
            ->actions([
                Action::make('abrirEscola')
                    ->label('Abrir escola')
                    ->button()
                    ->url($url)
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }

    public function toArray($notifiable): array
    {
        return [
            'matricula_id' => $this->matricula->id,
            'escola_id' => $this->escolaId,
        ];
    }
}
