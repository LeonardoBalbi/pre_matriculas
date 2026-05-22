<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
    }

    public function sendMessage($chatId, $text)
    {
        if (empty($this->token)) {
            Log::warning('Telegram token ausente');
            return null;
        }
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";
        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown',
        ]);
        if ($response->successful()) {
            return $response->json();
        }
        Log::error('Falha ao enviar mensagem no Telegram', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
        return null;
    }
}
