<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\TransferRequest;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification as NovaMessage;
use Illuminate\Support\Facades\URL;

class NovaAutorizarTransferencia extends Notification
{
    use Queueable;

    protected TransferRequest $request;

    public function __construct(TransferRequest $request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return [NovaChannel::class, 'database'];
    }

    public function toNova($notifiable)
    {
        $approve = route('admin.transfer.approve-direct', ['id' => $this->request->id]);
        $msg = "Transferência solicitada para matrícula {$this->request->matricula_id}.";

        return (new NovaMessage)
            ->message($msg)
            ->action('Autorizar', $approve)
            ->action('Recusar', route('admin.transfer.reject-direct', ['id' => $this->request->id]))
            ->icon('arrow-right')
            ->type('info');
    }

    public function toArray($notifiable)
    {
        return [
            'transfer_id' => $this->request->id,
        ];
    }
}
