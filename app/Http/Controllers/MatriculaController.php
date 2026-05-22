<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Distrito;
use App\Models\Bairro;
use App\Models\Escola;
use App\Models\Matricula;
use App\Models\Turma;
use App\Models\TipoDeficiencia;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Http\Requests\MatriculaRequest;
use App\Models\StatusMatricula;

use App\Models\MatriculaDeletedLog;

class MatriculaController extends Controller
{
    /**
     * Exibe o formulário de inscrição
     */
    public function index()
    {
        $distritos = Distrito::all();
        $deficiencias = TipoDeficiencia::all();
        return Inertia::render('Matricula/Inscricao', [
            'distritos' => $distritos,
            'deficiencias' => $deficiencias
        ]);
    }
    /**
     * Retorna escola_id e turma_id para o tipo de turma informado
     */
    public function escolaTurmaPorTipo(Request $request)
    {
        $tipo = $request->input('turma_especie');

        if (!$tipo) {
            return response()->json(['error' => 'Tipo de turma não informado'], 400);
        }

        $turma = DB::table('turmas')
            ->join('turma_tipos', 'turmas.turma_tipo_id', '=', 'turma_tipos.id')
            ->where('turma_tipos.tipo_descricao', $tipo)
            ->where('turmas.turma_status', 'ativa')
            ->select('turmas.id as turma_id', 'turmas.turma_escola_id as escola_id')
            ->first();

        if (!$turma) {
            return response()->json(['error' => 'Nenhuma turma encontrada para esse tipo'], 404);
        }

        return response()->json([
            'escola_id' => $turma->escola_id,
            'turma_id'  => $turma->turma_id
        ], 200);
    }

    public function bairro(Request $request)
    {
        $bairros = Bairro::where('distrito_id', $request->distrito)->get();
        return response()->json(['data' => $bairros], 200);
    }

    public function escola(Request $request)
    {
        // Busca todas as escolas do bairro
        $escolasQuery = Escola::where('escola_bairro_id', $request->bairro_id);

        // Se foi informada uma turma_especie, filtra as escolas que oferecem esse tipo
        if ($request->filled('turma_especie')) {
            // Descobre o id do tipo de turma pelo nome (ex: BERÇÁRIO A, BERÇÁRIO B, Nível 1, Nível 2)
            $turmaTipo = DB::table('turma_tipos')
                ->where('tipo_descricao', $request->turma_especie)
                ->first();
            if ($turmaTipo) {
                $idsPermitidos = DB::table('escola_turma_tipo')
                    ->where('turma_tipo_id', $turmaTipo->id)
                    ->pluck('escola_id')
                    ->toArray();
                if (!empty($idsPermitidos)) {
                    $escolasQuery = $escolasQuery->whereIn('id', $idsPermitidos);
                }
            } else {
            }
        }

        $escolas = $escolasQuery->get();
        return response()->json(['data' => $escolas->values()], 200);
    }

    public function turma(Request $request)
    {
        $turmas = DB::table('turmas')
            ->join('turma_tipos', 'turmas.turma_tipo_id', '=', 'turma_tipos.id')
            ->join('escolas', 'turmas.turma_escola_id', '=', 'escolas.id')
            ->select('turmas.*', 'turma_tipos.tipo_descricao', 'escolas.escola_nome')
            ->where([
                'turmas.turma_escola_id' => $request->escola_id,
                'turmas.turma_status'    => 'ativa'
            ])
            ->get();

        return response()->json(['data' => $turmas], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MatriculaRequest $request)
    {
        $data = $request->validated();

        if (empty($data['ano_letivo'])) {
            $data['ano_letivo'] = now()->year;
        }

        if (empty($data['situacao_matricula'])) {
            $padrao = StatusMatricula::where('status_matricula', 'Em análise')->first()
                ?: StatusMatricula::where('status_matricula', 'Em analise')->first();
            if ($padrao) {
                $data['situacao_matricula'] = $padrao->id;
            }
        }

        // Reaproveita dados do último registro do mesmo CPF quando anterior estiver "desistente" ou removido
        $cpfNorm = preg_replace('/\D+/', '', (string)($data['cpf_candidato'] ?? ''));
        if ($cpfNorm && strlen($cpfNorm) === 11) {
            $anterior = Matricula::withTrashed()
                ->whereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$cpfNorm])
                ->orderBy('updated_at', 'desc')
                ->first();

            if ($anterior && ((int)$anterior->situacao_matricula === 12 || $anterior->trashed())) {
                $camposCopia = [
                    'nome_candidato','data_nascimento','sexo','endereco','distrito_id','escola_bairro_id',
                    'escola_nome_id','turma_id','turma_especie','nome_responsavel','data_nasc_responsavel',
                    'cpf_responsavel','email_responsavel','tel_cel_responsavel','tel_fixo_responsavel',
                    'vulneravel_social','portador_deficiencia','deficiencias_tipo','grau_parentesco'
                ];
                foreach ($camposCopia as $campo) {
                    if (!array_key_exists($campo, $data) || empty($data[$campo])) {
                        $data[$campo] = $anterior->{$campo};
                    }
                }
                $data['inscricao_reativada'] = true;
                $data['data_reat_inscricao'] = now()->format('Y-m-d');
                $obs = trim((string)($data['observacao'] ?? ''));
                $data['observacao'] = rtrim($obs . ' Reativada da matrícula ID ' . $anterior->id);
            }
        }

        // Buscar nome da escola pelo ID
        if (!empty($data['escola_nome_id'])) {
            $escola = Escola::find($data['escola_nome_id']);
            $data['escola_nome'] = $escola ? $escola->escola_nome : null;
        } else {
            $data['escola_nome'] = null;
        }

        // --- LÓGICA DE EXCLUSÃO DE MATRÍCULA ANTERIOR IDÊNTICA ---
        // Se já existe uma matrícula com o mesmo CPF, removemos a anterior antes de criar a nova.
        if ($cpfNorm && strlen($cpfNorm) === 11) {
            $matriculasAnteriores = Matricula::whereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$cpfNorm])
                ->whereNull('deleted_at')
                ->get();

            foreach ($matriculasAnteriores as $antiga) {
                // Criar log de exclusão automática
                MatriculaDeletedLog::create([
                    'matricula_id'     => $antiga->id,
                    'deleted_by'       => auth()->id(), // null se for visitante
                    'deleted_by_name'  => auth()->user() ? auth()->user()->name : 'Visitante (Auto-Cleanup)',
                    'motivo_exclusao'  => 'Exclusão automática por nova inscrição idêntica',
                    'dados_matricula'  => $antiga->toArray(),
                ]);

                // Excluir a matrícula antiga
                $antiga->delete();
            }
        }

        $salvar = Matricula::create($data);
        $id = base64_encode($salvar->id);
        return response()->json([
            'id' => $id,
            'redirect_url' => route('inscritos.sucesso', ['id' => $id]),
            'download_url' => route('matricula.comprovante', ['id' => $id, 'tipo' => 'd']),
            'print_url' => route('matricula.comprovante', ['id' => $id, 'tipo' => 'p']),
        ], 200);
    }

    public function comprovante(string $id, string $tipo)
    {
        $id = base64_decode($id);
        $matricula = Matricula::findOrFail($id);

        $protocolo = $matricula->protocolo;
        $nome_candidato = mb_strtoupper($matricula->nome_candidato, 'UTF-8');
        $nome_responsavel = mb_strtoupper($matricula->nome_responsavel, 'UTF-8');
        $data_nascimento = date('d/m/Y', strtotime($matricula->data_nascimento));

        $escola_nome = $matricula->escola ? $matricula->escola->escola_nome : 'Não informado';
        $data_atual = now()->format('d/m/Y');

        $pdf = Pdf::loadView('pdfs.comprovante.comprovante-pre-matricula', compact(
            'protocolo',
            'data_nascimento',
            'escola_nome',
            'nome_candidato',
            'nome_responsavel',
            'data_atual'
        ));

        $nome_file = "COMPROVANTE DE PRÉ-MATRÍCULA - {$nome_candidato}.pdf";

        return $tipo === 'd' ? $pdf->download($nome_file) : $pdf->stream($nome_file);
    }

    public function update(MatriculaRequest $request, string $id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->update($request->validated() + ['updated_by' => auth()->id()]);

        return redirect()->back()->with('success', 'Matrícula atualizada com sucesso!');
    }

    public function escolaApiAll()
    {
        $escolas = Escola::select('id', 'escola_nome')->get();
        return response()->json(['data' => $escolas], 200);
    }

    public function escolaApiGet(string $id)
    {
        $escola = Escola::select('id', 'escola_nome')->find($id);
        return response()->json(['data' => $escola], 200);
    }

    public function turmaApiAll(string $escola_id)
    {
        $turmas = DB::table('turmas')
            ->join('turma_tipos', 'turmas.turma_tipo_id', '=', 'turma_tipos.id')
            ->join('escolas', 'turmas.turma_escola_id', '=', 'escolas.id')
            ->select('turmas.id', 'turmas.turma_escola_id', 'turmas.turma_tipo_id', 'turma_tipos.tipo_descricao', 'escolas.escola_nome')
            ->where(['turmas.turma_status' => 'ativa', 'turmas.turma_escola_id' => $escola_id])
            ->get();

        return response()->json(['data' => $turmas], 200);
    }

    public function turmaApiGet(string $id)
    {
        $turmas = DB::table('turmas')
            ->join('turma_tipos', 'turmas.turma_tipo_id', '=', 'turma_tipos.id')
            ->join('escolas', 'turmas.turma_escola_id', '=', 'escolas.id')
            ->select('turmas.id', 'turmas.turma_escola_id', 'turmas.turma_tipo_id', 'turma_tipos.tipo_descricao', 'escolas.escola_nome')
            ->where(['turmas.id' => $id, 'turmas.turma_status' => 'ativa'])
            ->get();

        return response()->json(['data' => $turmas], 200);
    }

    public function turmaApiFormGet(string $id)
    {
        $turma = Turma::findOrFail($id);
        $escola_id = $turma->turma_escola_id;

        $turmas = DB::table('turmas')
            ->join('turma_tipos', 'turmas.turma_tipo_id', '=', 'turma_tipos.id')
            ->join('escolas', 'turmas.turma_escola_id', '=', 'escolas.id')
            ->select('turmas.id', 'turmas.turma_escola_id', 'turmas.turma_tipo_id', 'turma_tipos.tipo_descricao', 'escolas.escola_nome')
            ->where(['turmas.turma_status' => 'ativa', 'turmas.turma_escola_id' => $escola_id])
            ->get();

        return response()->json(['data' => $turmas], 200);
    }

    public function buscarPorCpf(Request $request)
    {
        $cpf = preg_replace('/\D+/', '', (string) $request->input('cpf'));
        if (!$cpf || strlen($cpf) !== 11) {
            return response()->json(['error' => 'CPF inválido'], 422);
        }
        $matricula = Matricula::withTrashed()
            ->whereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$cpf])
            ->orderBy('updated_at', 'desc')
            ->first();
        if (!$matricula) {
            return response()->json(['data' => null], 200);
        }
        $dataNascimento = $matricula->data_nascimento;
        $dataResp = $matricula->data_nasc_responsavel;
        $dataNascimentoFmt = $dataNascimento
            ? ($dataNascimento instanceof Carbon ? $dataNascimento->format('Y-m-d') : date('Y-m-d', strtotime((string) $dataNascimento)))
            : null;
        $dataRespFmt = $dataResp
            ? ($dataResp instanceof Carbon ? $dataResp->format('Y-m-d') : date('Y-m-d', strtotime((string) $dataResp)))
            : null;

        return response()->json([
            'data' => [
                'nome_candidato' => $matricula->nome_candidato,
                'data_nascimento' => $dataNascimentoFmt,
                'sexo' => $matricula->sexo,
                'situacao_matricula' => $matricula->situacao_matricula,
                'endereco' => $matricula->endereco,
                'distrito_id' => $matricula->distrito_id,
                'escola_bairro_id' => $matricula->escola_bairro_id,
                'escola_nome_id' => $matricula->escola_nome_id,
                'turma_id' => $matricula->turma_id,
                'turma_especie' => $matricula->turma_especie,
                'nome_responsavel' => $matricula->nome_responsavel,
                'data_nasc_responsavel' => $dataRespFmt,
                'cpf_responsavel' => $matricula->cpf_responsavel,
                'email_responsavel' => $matricula->email_responsavel,
                'tel_cel_responsavel' => $matricula->tel_cel_responsavel,
                'tel_fixo_responsavel' => $matricula->tel_fixo_responsavel,
                'vulneravel_social' => $matricula->vulneravel_social,
                'portador_deficiencia' => $matricula->portador_deficiencia,
                'deficiencias_tipo' => $matricula->deficiencias_tipo,
                'grau_parentesco' => $matricula->grau_parentesco,
            ]
        ], 200);
    }
}
