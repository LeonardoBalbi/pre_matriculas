<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\TelegramService;
use App\Services\RespondIoService;
use App\Models\Matricula;

class TelegramWebhookController extends Controller
{
    private $telegram;
    private $templates;

    public function __construct(TelegramService $telegram, RespondIoService $respondIoService)
    {
        $this->telegram = $telegram;
        $this->templates = $respondIoService->getMessageTemplates();
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Webhook Telegram recebido', [
            'body_keys' => array_keys($request->all()),
        ]);

        $chatId = data_get($request->all(), 'message.chat.id');
        $text = strtolower(trim(data_get($request->all(), 'message.text', '')));

        if (!$chatId || $text === '') {
            return response()->json(['ok' => true], 200);
        }

        if ($this->containsKeyword($text, ['oi', 'olá', 'hello', 'hi', 'bom dia', 'boa tarde', 'boa noite'])) {
            $this->telegram->sendMessage($chatId, $this->templates['boas_vindas']);
        } elseif ($this->containsKeyword($text, ['status', 'protocolo', 'cpf', 'consulta', 'acompanhar'])) {
            $this->processStatusIntent($chatId, $text);
        } elseif ($this->containsKeyword($text, ['comprovante'])) {
            $this->processComprovanteIntent($chatId, $text);
        } elseif ($this->containsKeyword($text, ['matrícula', 'matricula', 'inscrição', 'inscricao', 'vaga'])) {
            $this->telegram->sendMessage($chatId, $this->templates['matricula_info']);
        } elseif ($this->containsKeyword($text, ['vagas', 'escolas'])) {
            $this->processInfoLinks($chatId);
        } elseif ($this->containsKeyword($text, ['horário', 'horario', 'funcionamento', 'atendimento', 'quando'])) {
            $this->telegram->sendMessage($chatId, $this->templates['horario_funcionamento']);
        } elseif ($this->containsKeyword($text, ['documento', 'documentos', 'papéis', 'papeis', 'preciso', 'necessário'])) {
            $this->telegram->sendMessage($chatId, $this->templates['documentos_necessarios']);
        } elseif ($this->containsKeyword($text, ['ajuda', 'help', 'socorro', 'dúvida', 'duvida'])) {
            $this->sendHelpMessage($chatId);
        } else {
            $this->sendDefaultMessage($chatId);
        }

        return response()->json(['ok' => true], 200);
    }

    public function status()
    {
        return response()->json(['status' => 'active', 'service' => 'Telegram Webhook', 'timestamp' => now()->toISOString()]);
    }

    private function containsKeyword(string $message, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (strpos($message, strtolower($keyword)) !== false) {
                return true;
            }
        }
        return false;
    }

    private function processStatusIntent(int|string $chatId, string $messageText): void
    {
        $cpf = $this->extractCpf($messageText);
        $protocolo = $this->extractProtocolo($messageText);

        $matricula = null;
        if ($protocolo) {
            $matricula = Matricula::with(['statusMatricula', 'escola', 'turma'])
                ->where('protocolo', $protocolo)
                ->orderBy('created_at', 'desc')
                ->first();
        } elseif ($cpf) {
            $matricula = Matricula::with(['statusMatricula', 'escola', 'turma'])
                ->whereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$cpf])
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if ($matricula) {
            $status = $matricula->statusMatricula ? $matricula->statusMatricula->status_matricula : 'Não definido';
            $escola = $matricula->escola ? $matricula->escola->escola_nome : 'A definir';
            $turma = $matricula->turma ? $matricula->turma->nome : ($matricula->turma_especie ?? 'A definir');
            $urlComp = route('matricula.comprovante', ['id' => base64_encode($matricula->id), 'tipo' => 'd']);

            $msg = "📊 *STATUS DA PRÉ-MATRÍCULA*\n\n" .
                   "👤 *Aluno:* {$matricula->nome_candidato}\n" .
                   "📋 *Protocolo:* {$matricula->protocolo}\n" .
                   "🏫 *Escola:* {$escola}\n" .
                   "📚 *Turma:* {$turma}\n" .
                   "🔖 *Situação:* {$status}\n\n" .
                   "🧾 *Comprovante:* {$urlComp}\n\n" .
                   "Precisa de mais ajuda? Digite *ajuda*.";

            $this->telegram->sendMessage($chatId, $msg);
            return;
        }

        $help = "Para consultar, envie:\n\n• *status* + *protocolo*\n• Ou *status* + *CPF*\n\nEx.: status 2025001234";
        $this->telegram->sendMessage($chatId, $help);
    }

    private function processComprovanteIntent(int|string $chatId, string $messageText): void
    {
        $cpf = $this->extractCpf($messageText);
        $protocolo = $this->extractProtocolo($messageText);

        $matricula = null;
        if ($protocolo) {
            $matricula = Matricula::where('protocolo', $protocolo)->first();
        } elseif ($cpf) {
            $matricula = Matricula::whereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$cpf])
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if ($matricula) {
            $urlComp = route('matricula.comprovante', ['id' => base64_encode($matricula->id), 'tipo' => 'd']);
            $msg = "🧾 *COMPROVANTE DE PRÉ-MATRÍCULA*\n\n" .
                   "📋 Protocolo: {$matricula->protocolo}\n" .
                   "👤 Aluno: {$matricula->nome_candidato}\n\n" .
                   "Acesse: {$urlComp}";
            $this->telegram->sendMessage($chatId, $msg);
            return;
        }

        $this->telegram->sendMessage($chatId, "Envie *comprovante* + *protocolo* ou *CPF*.\nEx.: comprovante 2025001234");
    }

    private function processInfoLinks(int|string $chatId): void
    {
        $base = config('app.url');
        $links = [
            '🏫 Escolas: ' . rtrim($base, '/') . '/',
            '📄 Tutorial: ' . rtrim($base, '/') . '/tutorial',
            '📝 Pré-matrícula: ' . rtrim($base, '/') . '/pre-matricula',
        ];
        $msg = "🔗 *INFORMAÇÕES ÚTEIS*\n\n" . implode("\n", $links) . "\n\nPrecisa de algo específico? Digite *ajuda*.";
        $this->telegram->sendMessage($chatId, $msg);
    }

    private function sendHelpMessage(int|string $chatId): void
    {
        $msg = "🆘 *COMO POSSO AJUDAR?*\n\n" .
               "📋 Digite *matrícula* - Informações sobre matrículas\n" .
               "🕐 Digite *horário* - Horários de atendimento\n" .
               "📄 Digite *documentos* - Lista de documentos necessários\n" .
               "📊 Digite *status* + protocolo/CPF - Consultar situação\n" .
               "🧾 Digite *comprovante* + protocolo/CPF - Gerar comprovante";
        $this->telegram->sendMessage($chatId, $msg);
    }

    private function sendDefaultMessage(int|string $chatId): void
    {
        $msg = "Obrigado pela sua mensagem!\n\n" .
               "Posso ajudar com:\n" .
               "• *matrícula* • *horário* • *documentos* • *status* • *comprovante* • *ajuda*";
        $this->telegram->sendMessage($chatId, $msg);
    }

    private function extractCpf(string $text): ?string
    {
        $digits = preg_replace('/\D+/', '', $text);
        if (!$digits) {
            return null;
        }
        if (preg_match('/(\d{11})/', $digits, $m)) {
            return $m[1];
        }
        return null;
    }

    private function extractProtocolo(string $text): ?string
    {
        $digits = preg_replace('/\D+/', '', $text);
        if (!$digits) {
            return null;
        }
        if (preg_match('/(\d{10})/', $digits, $m)) {
            return $m[1];
        }
        return null;
    }
}
