<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatriculaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'protocolo' => 'required',
            'ano_letivo' => 'required',
            'data_nascimento' => 'required|date',
            'nome_candidato' => 'required',
            'cpf_candidato' => 'required',
            'idade' => 'required',
            // 'situacao_matricula' => 'required',
            'observacao' => 'required',
            'idade_corte_meses' => 'required',
            'idade_data_corte' => 'required|date',
            'idade_data_corte_mes' => 'required',
            'idade_data_corte_dias' => 'required',
            'escola_nome' => 'required',
            'turma_id' => 'required',
            'sexo' => 'required',
            'irmao_creche' => 'required',
            'irmao_gemeo' => 'required',
            'nome_irmao_gemeo' => 'required',
            'carteira_vacinacao' => 'required',
            'cartao_sus' => 'required',
            'bolsa_familia' => 'required',
            'cad_unico' => 'required',
            'portador_deficiencia' => 'required',
            'deficiencias_tipo' => 'required_if:portador_deficiencia,1', // Se portador_deficiencia for igual a 1, deficiencias_tipo é obrigatório
            'distrito' => 'required',
            'endereco' => 'required',
            'escola_bairro_id' => 'required',
            'grau_parentesco' => 'required',
            'nome_responsavel' => 'required',
            'email_responsavel' => 'required|email',
            'data_nasc_responsavel' => 'required|date',
            'cpf_responsavel' => 'required',
            'rg_responsavel' => 'required',
            'mae_menor' => 'required',
            'escolaridade' => 'required',
            'tel_fixo_responsavel' => 'required',
            'tel_cel_responsavel' => 'required',
            'vulneravel_social' => 'required',
            'pedido_transferencia' => 'required',
            'aceite_edital' => 'required',
            'acao_judicial_candidato' => 'required',
            'candidato_remanescente' => 'required',
            'data_inscricao' => 'required|date',
            'data_reat_inscricao' => 'required|date',
            'inscricao_reativada' => 'required',
            'usr_login' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cpf.unique' => 'Já existe um candidato cadastrado com esse CPF.',
            'email.unique' => 'Já existe um candidato cadastrado com esse e-mail.',
            'cep.digits' => 'O campo CEP deve conter 8 dígitos.',
            'uf.size' => 'O campo UF deve conter 2 caracteres.',
            'telefone.phone' => 'O campo Telefone deve ser um número de telefone válido.',
            'celular.phone' => 'O campo Celular deve ser um número de telefone válido.',
            'tipo_deficiencia.required' => 'O campo Tipo de Deficiência é obrigatório quando a opção Deficiência é selecionada.',
        ];
    }
    

    
}
