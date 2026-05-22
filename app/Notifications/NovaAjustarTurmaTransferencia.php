<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Matricula;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification as NovaMessage;

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

    public function via($notifiable)
    {
        return [NovaChannel::class, 'database'];
    }

    public function toNova($notifiable)
    {
        $msg = "Transferência concluída sem turma para {$this->matricula->nome_candidato}. Atribua uma turma na escola destino.";
        $url = "/admin/resources/escolas/{$this->escolaId}";
        return (new NovaMessage)
            ->message($msg)
            ->action('Abrir Escola destino', $url)
            ->icon('exclamation')
            ->type('warning');
    }

    public function toArray($notifiable)
    {
        return [
            'matricula_id' => $this->matricula->id,
            'escola_id' => $this->escolaId,
        ];
    }
}
