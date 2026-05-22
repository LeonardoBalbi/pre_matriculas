<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Services\RespondIoService;
use App\Models\Matricula;

class WhatsAppWebhookController extends Controller
{
    private $respondIoService;

    public function __construct(RespondIoService $respondIoService)
    {
        $this->respondIoService = $respondIoService;
    }

    /**
     * Processar mensagens recebidas do WhatsApp via respond.io
     */
    public function handleWebhook(Request $request)
    {
        try {
            // Log da requisição recebida
            Log::info('Webhook WhatsApp recebido', [
                'headers' => [
                    'user-agent' => $request->header('User-Agent'),
                    'content-type' => $request->header('Content-Type'),
                ],
                'body_keys' => array_keys($request->all()),
            ]);

            // Verificar se é uma mensagem válida
            if (!$this->isValidMessage($request)) {
                return response()->json(['status' => 'ignored'], 200);
            }

            $messageData = $request->all();
            $from = $messageData['from'] ?? null;
            $messageText = $messageData['text']['body'] ?? '';

            if (!$from || !$messageText) {
                Log::warning('Mensagem WhatsApp inválida - dados faltando', $messageData);
                return response()->json(['status' => 'invalid'], 200);
            }

            // Processar a mensagem
            $this->processMessage($from, $messageText);

            return response()->json(['status' => 'processed'], 200);

        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook WhatsApp', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Verificar se a mensagem é válida para processamento
     */
    private function isValidMessage(Request $request): bool
    {
        $data = $request->all();

        // Verificar se é uma mensagem de texto
        if (!isset($data['type']) || $data['type'] !== 'text') {
            return false;
        }

        // Verificar se não é uma mensagem enviada por nós
        if (isset($data['direction']) && $data['direction'] === 'outbound') {
            return false;
        }

        // Verificar se tem o campo 'from'
        if (!isset($data['from'])) {
            return false;
        }

        return true;
    }

    /**
     * Processar mensagem recebida e enviar resposta apropriada
     */
    private function processMessage(string $from, string $messageText): void
    {
        $messageText = strtolower(trim($messageText));
        $templates = $this->respondIoService->getMessageTemplates();

        try {
            // Responder baseado no conteúdo da mensagem
            if ($this->containsKeyword($messageText, ['oi', 'olá', 'hello', 'hi', 'bom dia', 'boa tarde', 'boa noite'])) {
                $this->respondIoService->sendTextMessage($from, $templates['boas_vindas']);
            }
            elseif ($this->containsKeyword($messageText, ['status', 'protocolo', 'cpf', 'consulta', 'acompanhar'])) {
                $this->processStatusIntent($from, $messageText);
            }
            elseif ($this->containsKeyword($messageText, ['comprovante'])) {
                $this->processComprovanteIntent($from, $messageText);
            }
            elseif ($this->containsKeyword($messageText, ['matrícula', 'matricula', 'inscrição', 'inscricao', 'vaga'])) {
                $this->respondIoService->sendTextMessage($from, $templates['matricula_info']);
            }
            elseif ($this->containsKeyword($messageText, ['vagas', 'escolas'])) {
                $this->processInfoLinks($from);
            }
            elseif ($this->containsKeyword($messageText, ['horário', 'horario', 'funcionamento', 'atendimento', 'quando'])) {
                $this->respondIoService->sendTextMessage($from, $templates['horario_funcionamento']);
            }
            elseif ($this->containsKeyword($messageText, ['documento', 'documentos', 'papéis', 'papeis', 'preciso', 'necessário'])) {
                $this->respondIoService->sendTextMessage($from, $templates['documentos_necessarios']);
            }
            elseif ($this->containsKeyword($messageText, ['ajuda', 'help', 'socorro', 'dúvida', 'duvida'])) {
                $this->sendHelpMessage($from);
            }
            else {
                $this->sendDefaultMessage($from);
            }

            Log::info('Resposta automática enviada', [
                'from' => $from,
                'message_received' => $messageText
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao enviar resposta automática', [
                'from' => $from,
                'message' => $messageText,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Processar intenção de consulta de status por protocolo ou CPF
     */
    private function processStatusIntent(string $from, string $messageText): void
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

            $this->respondIoService->sendTextMessage($from, $msg);
            return;
        }

        $help = "Para consultar, envie uma mensagem com:\n\n" .
                "• A palavra *status* seguida do *protocolo* (ex: status 2025001234)\n" .
                "• Ou *status* seguido do *CPF* do candidato (ex: status 12345678900)\n\n" .
                "Exemplo: *status 2025001234*";
        $this->respondIoService->sendTextMessage($from, $help);
    }

    /**
     * Gerar e enviar link de comprovante via protocolo ou CPF
     */
    private function processComprovanteIntent(string $from, string $messageText): void
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
            $this->respondIoService->sendTextMessage($from, $msg);
            return;
        }

        $this->respondIoService->sendTextMessage($from, "Para gerar o comprovante, envie:\n\n• *comprovante* + protocolo\n• Ou *comprovante* + CPF\n\nEx.: comprovante 2025001234");
    }

    /**
     * Enviar links úteis para escolas e vagas
     */
    private function processInfoLinks(string $from): void
    {
        $base = config('app.url');
        $links = [
            '🏫 Escolas: ' . rtrim($base, '/') . '/',
            '📄 Tutorial: ' . rtrim($base, '/') . '/tutorial',
            '📝 Pré-matrícula: ' . rtrim($base, '/') . '/pre-matricula',
        ];
        $msg = "🔗 *INFORMAÇÕES ÚTEIS*\n\n" . implode("\n", $links) . "\n\nPrecisa de algo específico? Digite *ajuda*.";
        $this->respondIoService->sendTextMessage($from, $msg);
    }

    /**
     * Extrair CPF (11 dígitos) da mensagem
     */
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

    /**
     * Extrair protocolo (10 dígitos: ano + sequência) da mensagem
     */
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

    /**
     * Verificar se a mensagem contém alguma palavra-chave
     */
    private function containsKeyword(string $message, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (strpos($message, strtolower($keyword)) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Enviar mensagem de ajuda
     */
    private function sendHelpMessage(string $from): void
    {
        $helpMessage = "🆘 *COMO POSSO AJUDAR?*\n\n" .
                      "Aqui estão as opções disponíveis:\n\n" .
                      "📋 Digite *matrícula* - Informações sobre matrículas\n" .
                      "🕐 Digite *horário* - Horários de atendimento\n" .
                      "📄 Digite *documentos* - Lista de documentos necessários\n\n" .
                      "📞 *Contato direto:*\n" .
                      "Secretaria Municipal de Educação\n" .
                      "Segunda a Sexta: 8h às 17h\n\n" .
                      "💬 Ou continue conversando comigo!";

        $this->respondIoService->sendTextMessage($from, $helpMessage);
    }

    /**
     * Enviar mensagem padrão para mensagens não reconhecidas
     */
    private function sendDefaultMessage(string $from): void
    {
        $defaultMessage = "🤖 Obrigado pela sua mensagem!\n\n" .
                         "Não consegui entender exatamente o que você precisa, mas posso ajudar com:\n\n" .
                         "📋 *matrícula* - Informações sobre matrículas\n" .
                         "🕐 *horário* - Horários de atendimento\n" .
                         "📄 *documentos* - Documentos necessários\n" .
                         "🆘 *ajuda* - Ver todas as opções\n\n" .
                         "Digite uma das palavras acima ou continue conversando comigo! 😊";

        $this->respondIoService->sendTextMessage($from, $defaultMessage);
    }

    /**
     * Endpoint para verificar status do webhook
     */
    public function status()
    {
        return response()->json([
            'status' => 'active',
            'service' => 'WhatsApp Webhook',
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Endpoint para verificação do webhook (GET)
     */
    public function verify(Request $request)
    {
        // Verificação básica para validação do webhook
        $challenge = $request->get('hub_challenge');
        
        if ($challenge) {
            return response($challenge, 200);
        }
        
        return response()->json(['status' => 'webhook_ready'], 200);
    }
}
