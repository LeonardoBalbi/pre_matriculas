<?php

namespace App\Notifications;

use App\Models\TransferRequest;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AutorizarTransferenciaNotification extends Notification
{
    use Queueable;

    protected TransferRequest $request;

    public function __construct(TransferRequest $request)
    {
        $this->request = $request;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $approve = route('admin.transfer.approve-direct', ['id' => $this->request->id]);
        $reject = route('admin.transfer.reject-direct', ['id' => $this->request->id]);

        return FilamentNotification::make()
            ->title('Transferencia solicitada')
            ->body("Matricula {$this->request->matricula_id} aguardando autorizacao.")
            ->icon('heroicon-o-arrows-right-left')
            ->info()
            ->actions([
                Action::make('autorizar')
                    ->label('Autorizar')
                    ->button()
                    ->url($approve)
                    ->markAsRead(),
                Action::make('recusar')
                    ->label('Recusar')
                    ->color('danger')
                    ->url($reject)
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }

    public function toArray($notifiable): array
    {
        return [
            'transfer_id' => $this->request->id,
        ];
    }
}
