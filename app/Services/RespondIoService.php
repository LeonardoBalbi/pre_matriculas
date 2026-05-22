<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class RespondIoService
{
    private $apiKey;
    private $channelId;
    private $baseUrl = 'https://api.respond.io/v1';

    public function __construct()
    {
        $this->apiKey = config('services.respond_io.api_key');
        $this->channelId = config('services.respond_io.channel_id');
    }

    /**
     * Enviar mensagem de texto via respond.io
     */
    public function sendTextMessage($phoneNumber, $message)
    {
        try {
            if (empty($this->apiKey) || empty($this->channelId)) {
                $formattedPhone = $this->formatPhoneNumber($phoneNumber);
                $wa = 'https://web.whatsapp.com/send/?phone=' . $formattedPhone . '&text=' . urlencode($message);
                Log::info('Modo gratuito: gerar link WhatsApp Web', [
                    'phone' => $formattedPhone,
                    'chars' => strlen($message),
                    'url' => $wa,
                ]);
                return ['web_link' => $wa];
            }
            $formattedPhone = $this->formatPhoneNumber($phoneNumber);

            $payload = [
                'to' => $formattedPhone,
                'channel_id' => $this->channelId,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ];

            Log::info('Enviando WhatsApp via respond.io', [
                'to' => $payload['to'],
                'channel_id' => $payload['channel_id'],
                'chars' => strlen($message),
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . '/send', $payload);

            if ($response->successful()) {
                Log::info('Mensagem WhatsApp enviada com sucesso', [
                    'phone' => $formattedPhone,
                    'message_length' => strlen($message)
                ]);
                return $response->json();
            } else {
                Log::error('Erro ao enviar mensagem WhatsApp', [
                    'phone' => $formattedPhone,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                throw new Exception('Falha ao enviar mensagem: ' . $response->body());
            }
        } catch (Exception $e) {
            Log::error('Exceção ao enviar WhatsApp', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Enviar mensagem de confirmação de matrícula
     */
    public function sendConfirmationMessage($phoneNumber, $matricula)
    {
        $message = $this->buildConfirmationMessage($matricula);
        return $this->sendTextMessage($phoneNumber, $message);
    }

    /**
     * Construir mensagem de confirmação personalizada
     */
    private function buildConfirmationMessage($matricula)
    {
        return "🎉 *MATRÍCULA CONFIRMADA!*\n\n" .
               "Olá! Sua matrícula foi realizada com sucesso:\n\n" .
               "👤 *Aluno:* {$matricula->nome_aluno}\n" .
               "📋 *Protocolo:* #{$matricula->id}\n" .
               "🏫 *Escola:* " . ($matricula->escola ? $matricula->escola->nome : 'A definir') . "\n" .
               "📚 *Turma:* " . ($matricula->turma ? $matricula->turma->nome : 'A definir') . "\n" .
               "📅 *Data:* " . $matricula->created_at->format('d/m/Y H:i') . "\n\n" .
               "📄 *Próximos passos:*\n" .
               "• Aguarde contato da escola\n" .
               "• Prepare a documentação necessária\n" .
               "• Acompanhe o processo pelo protocolo\n\n" .
               "❓ *Dúvidas?* Responda esta mensagem!\n\n" .
               "_Secretaria Municipal de Educação_";
    }

    /**
     * Formatar número de telefone para padrão brasileiro
     */
    private function formatPhoneNumber($phone)
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (!$digits) {
            return $digits;
        }
        if (substr($digits, 0, 2) !== '55') {
            if (strlen($digits) === 10) {
                $digits = '55' . substr($digits, 0, 2) . '9' . substr($digits, 2);
            } elseif (strlen($digits) === 11) {
                $digits = '55' . $digits;
            } else {
                $digits = '55' . $digits;
            }
        } else {
            if (strlen($digits) === 12) {
                $digits = substr($digits, 0, 4) . '9' . substr($digits, 4);
            }
        }
        return $digits;
    }

    /**
     * Obter templates de mensagens
     */
    public function getMessageTemplates()
    {
        return [
            'matricula_info' => "📋 *INFORMAÇÕES SOBRE MATRÍCULA*\n\n" .
                              "Para realizar sua matrícula, você precisa:\n\n" .
                              "📄 *Documentos necessários:*\n" .
                              "• RG e CPF do responsável\n" .
                              "• Certidão de nascimento do aluno\n" .
                              "• Comprovante de residência\n" .
                              "• Cartão de vacinação\n" .
                              "• Histórico escolar (se houver)\n\n" .
                              "🕐 *Horário de atendimento:*\n" .
                              "Segunda a Sexta: 8h às 17h\n\n" .
                              "📍 *Local:* Secretaria Municipal de Educação",

            'horario_funcionamento' => "🕐 *HORÁRIOS DE ATENDIMENTO*\n\n" .
                                     "📅 *Segunda a Sexta-feira*\n" .
                                     "⏰ Das 8h00 às 17h00\n\n" .
                                     "📍 *Secretaria Municipal de Educação*\n\n" .
                                     "⚠️ *Importante:*\n" .
                                     "• Atendimento por ordem de chegada\n" .
                                     "• Traga todos os documentos\n" .
                                     "• Chegue com antecedência",

            'documentos_necessarios' => "📄 *DOCUMENTOS PARA MATRÍCULA*\n\n" .
                                      "✅ *Obrigatórios:*\n" .
                                      "• RG e CPF do responsável\n" .
                                      "• Certidão de nascimento do aluno\n" .
                                      "• Comprovante de residência atualizado\n" .
                                      "• Cartão de vacinação em dia\n\n" .
                                      "📚 *Se já estudou:*\n" .
                                      "• Histórico escolar\n" .
                                      "• Declaração de transferência\n\n" .
                                      "⚠️ *Atenção:* Todos os documentos devem ser originais + cópia",

            'boas_vindas' => "👋 *Olá! Bem-vindo(a)!*\n\n" .
                           "Sou o assistente virtual da Secretaria Municipal de Educação.\n\n" .
                           "🤖 *Como posso ajudar?*\n" .
                           "• Digite *matrícula* para informações sobre matrículas\n" .
                           "• Digite *horário* para horários de atendimento\n" .
                           "• Digite *documentos* para lista de documentos\n\n" .
                           "📞 *Precisa de mais ajuda?*\n" .
                           "Entre em contato conosco!"
        ];
    }
}
