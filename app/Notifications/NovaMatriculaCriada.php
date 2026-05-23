<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Notifications\Notification as LaravelNotification;

use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Matricula;
use Laravel\Nova\Notifications\NovaNotification as NovaMessage;

class NovaMatriculaCriada extends LaravelNotification
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
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $url = url("/admin/matriculas/{$this->matricula->id}");
        $protocolo = $this->matricula->protocolo ?: $this->matricula->id;

        return FilamentNotification::make()
            ->title('Nova matricula feita')
            ->body("Protocolo {$protocolo} - {$this->matricula->nome_candidato}")
            ->icon('heroicon-o-user-plus')
            ->info()
            ->actions([
                Action::make('verMatricula')
                    ->label('Ver matricula')
                    ->button()
                    ->url($url)
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }

    public function toMail($notifiable)
    {
        $urlNova = url("/admin/matriculas/{$this->matricula->id}");
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
            'url'              => url("/admin/matriculas/{$this->matricula->id}"),
        ];
    }
}
