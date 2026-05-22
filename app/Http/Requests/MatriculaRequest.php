<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class MatriculaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Normaliza CPF
        if ($this->has('cpf_candidato')) {
            $cpf = preg_replace('/\D+/', '', $this->input('cpf_candidato'));
            $this->merge(['cpf_candidato' => $cpf ?: null]);
        }

        // Normaliza e-mail
        if ($this->has('email_responsavel')) {
            $this->merge(['email_responsavel' => strtolower(trim($this->input('email_responsavel')))]);
        }
    }

    public function rules(): array
    {
        return [
            'data_nascimento'      => 'required|date',
            'idade'                => 'nullable',
            'idade_data_corte'     => 'nullable',
            'irmao_creche'         => 'nullable',
            'irmao_gemeo'          => 'nullable',
            'bolsa_familia'        => 'nullable',
            'vulneravel_social'    => 'nullable',
            'endereco'             => 'nullable',
            'grau_parentesco'      => 'nullable',
            'portador_deficiencia' => 'nullable',
            'deficiencias_tipo'    => 'nullable',
            'escola_bairro_id'     => 'required',
            'escola_nome_id'       => 'required',
            'nome_irmao_gemeo'     => 'nullable',
            'cad_unico'            => 'nullable',
            'mae_menor'            => 'nullable',
            'tel_cel_responsavel'  => 'required',
            'tel_fixo_responsavel' => 'nullable',
            'nome_candidato'       => 'required|string',

            // CPF validado no withValidator
            'cpf_candidato'        => ['required', 'string'],

            'sexo'                 => 'required|string',
            'distrito_id'          => 'required',
            'turma_id'             => 'nullable',
            'turma_especie'        => 'nullable',
            'carteira_vacinacao'   => 'required',
            'nome_responsavel'     => 'required',
            'data_nasc_responsavel'=> 'required|date',
            'cpf_responsavel'      => 'nullable',

            'email_responsavel'    => 'required|email',

            'declaro'              => 'required|accepted',
            'edital'               => 'required|accepted',
            'ano_letivo'           => 'required|integer|min:2020|max:2100',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $cpf = $this->input('cpf_candidato');
            if (!$cpf) {
                return;
            }

            // id atual (update)
            $matricula = $this->route('matricula');
            $matriculaId = is_object($matricula) ? $matricula->id : $matricula;

            // busca CPF no banco (apenas registros ativos: deleted_at IS NULL)
            $query = DB::table('matriculas')
                ->whereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$cpf])
                ->whereNull('deleted_at');

            if ($matriculaId) {
                $query->where('id', '<>', $matriculaId);
            }

            $existe = DB::table('matriculas')
                ->whereRaw("REPLACE(REPLACE(REPLACE(cpf_candidato, '.', ''), '-', ''), ' ', '') = ?", [$cpf])
                ->whereNull('deleted_at') // 👈 garante que NÃO pega soft deletes
                ->when($matriculaId, fn($q) => $q->where('id', '<>', $matriculaId))
                ->first();

            // Verifica se o CPF consta na lista de "CPFs Cadastrados/Bloqueados"
            // Se estiver na lista -> BLOQUEIA.
            // Se o admin tiver removido da lista -> LIBERA (mesmo que exista matrícula).
            $temBloqueio = DB::table('cpf_autorizados')
                ->where('cpf', preg_replace('/\D+/', '', $cpf))
                ->exists();

            if ($existe && (int) $existe->situacao_matricula !== 12 && $temBloqueio) {
                $validator->errors()->add(
                    'cpf_candidato',
                    'Já existe uma matrícula ativa para este CPF. Para novo cadastro, solicite a liberação administrativa.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'cpf_candidato.required' => 'O CPF do candidato é obrigatório.',
            'cpf_candidato.string'   => 'O CPF deve ser um texto válido.',
            'email_responsavel.unique' => 'Já existe um responsável cadastrado com esse e-mail.',
            'declaro.required'       => 'Você precisa aceitar a declaração de veracidade.',
            'edital.required'        => 'Você precisa aceitar o edital.',
        ];
    }

    public function attributes(): array
    {
        return [
            'data_nascimento'       => 'Data de Nascimento',
            'nome_candidato'        => 'Nome do Candidato',
            'cpf_candidato'         => 'CPF do Candidato',
            'sexo'                  => 'Sexo',
            'distrito_id'           => 'Distrito',
            'escola_bairro_id'      => 'Bairro da Escola',
            'escola_nome_id'        => 'Escola',
            'turma_id'              => 'Turma',
            'turma_especie'         => 'Turma Calculada',
            'carteira_vacinacao'    => 'Carteira de Vacinação',
            'nome_responsavel'      => 'Nome do Responsável',
            'data_nasc_responsavel' => 'Data de Nascimento do Responsável',
            'cpf_responsavel'       => 'CPF do Responsável',
            'email_responsavel'     => 'E-mail do Responsável',
            'tel_cel_responsavel'   => 'Celular do Responsável',
            'declaro'               => 'Declaração de Veracidade',
            'edital'                => 'Edital',
        ];
    }
}
