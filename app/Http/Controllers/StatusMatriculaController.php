<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\StatusMatricula;

class StatusMatriculaController extends Controller
{


public function index(Request $request)
{
    $query = Matricula::where('situacao_matricula', 13);

    if ($request->filled('nome')) {
        $query->where('nome_candidato', 'like', '%' . $request->nome . '%');
    }

    $matriculas = $query
        ->orderBy('nome_candidato')
        ->paginate(5)
        ->appends($request->query());

    return view('pre-matricula-status', compact('matriculas'));
}

public function confirmar(Request $request, string $id)
{
    $matricula = Matricula::findOrFail($id);
    $matriculadoId = StatusMatricula::where('status_matricula', 'Matriculado')->value('id');
    if ($matriculadoId) {
        $matricula->situacao_matricula = $matriculadoId;
        $matricula->save();
    }
    $telefone = $matricula->tel_cel_responsavel;
    if ($telefone) {
        $url = route('matricula.comprovante', ['id' => base64_encode($matricula->id), 'tipo' => 'd']);
        $escola = $matricula->escola ? $matricula->escola->escola_nome : 'Não informado';
        $mensagem = "MATRÍCULA CONFIRMADA%0AProtocolo: {$matricula->protocolo}%0AAluno: {$matricula->nome_candidato}%0AEscola: {$escola}%0AAno Letivo: {$matricula->ano_letivo}%0AComprovante: {$url}";
        $digits = preg_replace('/[^0-9]/', '', $telefone);
        if ($digits && substr($digits, 0, 2) !== '55') {
            $digits = '55' . $digits;
        }
        $wa = "https://web.whatsapp.com/send/?phone={$digits}&text={$mensagem}";
        return redirect()->away($wa);
    }
    return redirect()->back()->with('success', 'Matrícula confirmada.');
}

public function enviarWhatsapp(Request $request, string $id)
{
    $matricula = Matricula::findOrFail($id);
    $data = $request->validate([
        'nome' => ['required', 'string', 'max:255'],
        'mensagem' => ['required', 'string', 'max:2000'],
        'telefone' => ['nullable', 'string', 'max:30'],
    ]);

    $telefone = $data['telefone'] ?: $matricula->tel_cel_responsavel;
    if (!$telefone) {
        return redirect()->back()->with('error', 'Telefone do responsável não cadastrado.');
    }

    $digits = preg_replace('/[^0-9]/', '', $telefone);
    if ($digits && substr($digits, 0, 2) !== '55') {
        $digits = '55' . $digits;
    }
    $mensagem = urlencode("Olá, {$data['nome']}!\n\n{$data['mensagem']}");
    $wa = "https://web.whatsapp.com/send/?phone={$digits}&text={$mensagem}";
    return redirect()->away($wa);
}

public function testarWhatsapp(string $id)
{
    $matricula = Matricula::findOrFail($id);
    $telefone = $matricula->tel_cel_responsavel;
    if (!$telefone) {
        return response()->json(['ok' => false, 'message' => 'Telefone do responsável não cadastrado'], 400);
    }
    $digits = preg_replace('/[^0-9]/', '', $telefone);
    if ($digits && substr($digits, 0, 2) !== '55') {
        $digits = '55' . $digits;
    }
    $mensagem = urlencode("Teste automático: envio de WhatsApp para o protocolo {$matricula->protocolo}.");
    $wa = "https://web.whatsapp.com/send/?phone={$digits}&text={$mensagem}";
    return response()->json(['ok' => true, 'url' => $wa], 200);
}

public function abrirWhatsapp(string $id)
{
    $matricula = Matricula::findOrFail($id);
    $telefone = $matricula->tel_cel_responsavel;
    if (!$telefone) {
        return redirect()->back()->with('error', 'Telefone do responsável não cadastrado.');
    }
    $digits = preg_replace('/[^0-9]/', '', $telefone);
    if ($digits && substr($digits, 0, 2) !== '55') {
        $digits = '55' . $digits;
    }
    if (strlen($digits) === 12) {
        $digits = substr($digits, 0, 4) . '9' . substr($digits, 4);
    }
    $urlComp = route('matricula.comprovante', ['id' => base64_encode($matricula->id), 'tipo' => 'd']);
    $escola = $matricula->escola ? $matricula->escola->escola_nome : 'Não informado';
    $msg = "MATRÍCULA CONFIRMADA\n\nProtocolo: {$matricula->protocolo}\nAluno: {$matricula->nome_candidato}\nEscola: {$escola}\nAno Letivo: {$matricula->ano_letivo}\nComprovante: {$urlComp}";
    $wa = "https://web.whatsapp.com/send/?phone={$digits}&text=" . urlencode($msg);
    return redirect()->away($wa);
}

public function apiStatusByProtocol(string $input)
    {
        $input = trim($input);
        $inputLimpo = preg_replace('/\D/', '', $input);

        // Log para depuração
        \Illuminate\Support\Facades\Log::info("Bot buscando por: " . $input);

        $matricula = Matricula::withTrashed()->with(['escola', 'statusMatricula'])
            ->where(function ($query) use ($input, $inputLimpo) {
                $query->where('protocolo', $input)
                    ->orWhereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$inputLimpo]);
            })
            ->first();

        if (!$matricula) {
            \Illuminate\Support\Facades\Log::warning("Dados não encontrados no banco para: " . $input);
            return response()->json([
                'success' => false,
                'message' => 'Matrícula não encontrada.'
            ], 404);
        }

        // Se a relação escola for nula, tenta pegar o nome direto do atributo escola_nome
        $nomeEscola = 'Não definida';
        if ($matricula->escola) {
            $nomeEscola = $matricula->escola->escola_nome;
        } elseif ($matricula->escola_nome) {
            $nomeEscola = $matricula->escola_nome;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nome' => $matricula->nome_candidato,
                'status' => $matricula->statusMatricula ? $matricula->statusMatricula->status_matricula : 'Em análise',
                'escola' => $nomeEscola,
                'ano_letivo' => $matricula->ano_letivo,
                'protocolo' => $matricula->protocolo
            ]
        ]);
    }

}

// return response()->json($status);
