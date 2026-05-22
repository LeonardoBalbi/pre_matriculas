<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Matricula;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification as NovaMessage;

class NovaMatriculaCriada extends Notification
{
    use Queueable;

    protected Matricula $matricula;

    public function __construct(Matricula $matricula)
    {
        $this->matricula = $matricula;
    }

    /**
     * Define os canais de entrega da notificação.
     */
    public function via($notifiable)
    {
        return [NovaChannel::class, 'database'];
    }

    public function toMail($notifiable)
    {
        $urlNova = url("/nova/resources/matriculas/{$this->matricula->id}");
        $encodedId = base64_encode((string) $this->matricula->id);
        $dl = url("/matricula/comprovante/{$encodedId}/d");
        $pr = url("/matricula/comprovante/{$encodedId}/p");
        return (new MailMessage)
            ->subject('Nova matrícula criada')
            ->greeting('Olá')
            ->line("Uma nova matrícula foi criada para {$this->matricula->nome_candidato}.")
            ->line("Responsável: {$this->matricula->nome_responsavel}")
            ->action('Ver Matrícula', $urlNova)
            ->line("Baixar comprovante: {$dl}")
            ->line("Imprimir comprovante: {$pr}")
            ->line('Este é um aviso automático do sistema de pré-matrícula.');
    }

    /**
     * Notificação no sino do Laravel Nova.
     */
    public function toNova($notifiable)
    {
        $mensagem = "Nova matrícula criada para {$this->matricula->nome_candidato}.";

        return (new NovaMessage)
            ->message($mensagem)
            ->action(
                'Ver Matrícula',
                "/resources/matriculas/{$this->matricula->id}"
            )
            ->icon('user')
            ->type('info');
    }

    /**
     * Notificação via database (array).
     */
    public function toArray($notifiable)
    {
        return [
            'matricula_id'     => $this->matricula->id,
            'nome_candidato'   => $this->matricula->nome_candidato,
            'nome_responsavel' => $this->matricula->nome_responsavel,
            'mensagem'         => 'Uma nova matrícula foi criada para ' . $this->matricula->nome_candidato,
            'url'              => url("/nova/resources/matriculas/{$this->matricula->id}"),
        ];
    }
}
