<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Matricula;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification as NovaMessage;

class NovaAbrirWhatsappMatricula extends Notification
{
    use Queueable;

    protected Matricula $matricula;

    public function __construct(Matricula $matricula)
    {
        $this->matricula = $matricula;
    }

    public function via($notifiable)
    {
        return [NovaChannel::class, 'database'];
    }

    public function toNova($notifiable)
    {
        $telefone = $this->matricula->tel_cel_responsavel;
        $digits = preg_replace('/[^0-9]/', '', (string) $telefone);
        if ($digits && substr($digits, 0, 2) !== '55') {
            $digits = '55' . $digits;
        }
        if (strlen($digits) === 12) {
            $digits = substr($digits, 0, 4) . '9' . substr($digits, 4);
        }
        $encodedId = base64_encode((string) $this->matricula->id);
        $comp = url("/matricula/comprovante/{$encodedId}/d");
        $escola = $this->matricula->escola ? $this->matricula->escola->escola_nome : 'Não informado';
        $msg = "MATRÍCULA CONFIRMADA\n\nProtocolo: {$this->matricula->protocolo}\nAluno: {$this->matricula->nome_candidato}\nEscola: {$escola}\nAno Letivo: {$this->matricula->ano_letivo}\nComprovante: {$comp}";
        $wa = "https://web.whatsapp.com/send/?phone={$digits}&text=" . urlencode($msg);
        $mensagem = "Matrícula confirmada para {$this->matricula->nome_candidato}. Abrir WhatsApp Web.";

        return (new NovaMessage)
            ->message($mensagem)
            ->action('Abrir WhatsApp Web', route('pre-matricula.abrir_whatsapp', ['id' => $this->matricula->id]))
            ->icon('check-circle')
            ->type('success');
    }

    public function toArray($notifiable)
    {
        return [
            'matricula_id' => $this->matricula->id,
            'mensagem' => 'Matrícula confirmada. Abrir WhatsApp Web.',
            'url' => url("/pre-matricula/abrir-whatsapp/{$this->matricula->id}"),
        ];
    }
}
