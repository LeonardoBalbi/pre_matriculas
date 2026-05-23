<?php

namespace App\Notifications;

use App\Models\Matricula;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AbrirWhatsappMatriculaNotification extends Notification
{
    use Queueable;

    protected Matricula $matricula;

    public function __construct(Matricula $matricula)
    {
        $this->matricula = $matricula;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return FilamentNotification::make()
            ->title('Matricula confirmada')
            ->body("{$this->matricula->nome_candidato} foi confirmado. Abra o WhatsApp para avisar o responsavel.")
            ->icon('heroicon-o-check-circle')
            ->success()
            ->actions([
                Action::make('abrirWhatsapp')
                    ->label('Abrir WhatsApp')
                    ->button()
                    ->url(route('pre-matricula.abrir_whatsapp', ['id' => $this->matricula->id]))
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }

    public function toArray($notifiable): array
    {
        return [
            'matricula_id' => $this->matricula->id,
            'mensagem' => 'Matricula confirmada. Abrir WhatsApp Web.',
            'url' => url("/pre-matricula/abrir-whatsapp/{$this->matricula->id}"),
        ];
    }
}
