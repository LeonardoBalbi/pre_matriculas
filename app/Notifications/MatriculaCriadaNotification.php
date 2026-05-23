<?php

namespace App\Notifications;

use App\Models\Matricula;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as LaravelNotification;

class MatriculaCriadaNotification extends LaravelNotification
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

    public function toMail($notifiable): MailMessage
    {
        $urlAdmin = url("/admin/matriculas/{$this->matricula->id}");
        $encodedId = base64_encode((string) $this->matricula->id);
        $downloadUrl = url("/matricula/comprovante/{$encodedId}/d");
        $printUrl = url("/matricula/comprovante/{$encodedId}/p");

        return (new MailMessage)
            ->subject('Nova matricula criada')
            ->greeting('Ola')
            ->line("Uma nova matricula foi criada para {$this->matricula->nome_candidato}.")
            ->line("Responsavel: {$this->matricula->nome_responsavel}")
            ->action('Ver matricula', $urlAdmin)
            ->line("Baixar comprovante: {$downloadUrl}")
            ->line("Imprimir comprovante: {$printUrl}")
            ->line('Este e um aviso automatico do sistema de pre-matricula.');
    }

    public function toArray($notifiable): array
    {
        return [
            'matricula_id' => $this->matricula->id,
            'nome_candidato' => $this->matricula->nome_candidato,
            'nome_responsavel' => $this->matricula->nome_responsavel,
            'mensagem' => 'Uma nova matricula foi criada para ' . $this->matricula->nome_candidato,
            'url' => url("/admin/matriculas/{$this->matricula->id}"),
        ];
    }
}
