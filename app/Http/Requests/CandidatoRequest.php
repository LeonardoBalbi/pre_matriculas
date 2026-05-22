<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_vagas' => 'required',
            'nome' => 'required',
            // 'cpf' => 'required',
            'cpf' => 'required|unique:candidatos,cpf',
            'data_nasc' => 'required|date',
            'cor_raca' => 'required',
            'nacionalidade' => 'required',
            'naturalidade' => 'required',
            'sexo' => 'required',
            'estado_civil' => 'required',
            'deficiencia' => 'required',
            'nome_pai' => 'required',
            'nome_mae' => 'required',
            'escolaridade' => 'required',
            'rg' => 'required',
            'rg_emissor' => 'required',
            'rg_estado' => 'required',
            'rg_data_emissao' => 'required|date',
            'cep' => 'required|digits:8',
            'endereco' => 'required',
            'numero' => 'required',   
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',     
            'celular' => 'required',
            'email' => 'required|email',  
            'tipo_deficiencia' => $this->deficiencia === 'Sim' ? 'required' : 'nullable',       
        ];
    }

    public function attributes()
{
    return [
        'id_vagas' => 'Vaga',
        'nome' => 'Nome',
        'cpf' => 'CPF',
        'data_nasc' => 'Data de Nascimento',
        'cor_raca' => 'Cor/Raça',
        'nacionalidade' => 'Nacionalidade',
        'naturalidade' => 'Naturalidade',
        'sexo' => 'Sexo',
        'estado_civil' => 'Estado Civil',
        'deficiencia' => 'Deficiência',
        'nome_pai' => 'Nome do Pai',
        'nome_mae' => 'Nome da Mãe',
        'escolaridade' => 'Escolaridade',
        'rg' => 'RG',
        'rg_emissor' => 'Órgão Emissor',
        'rg_estado' => 'Estado',
        'rg_data_emissao' => 'Data de Emissão',
        'cep' => 'CEP',
        'endereco' => 'Endereço',
        'numero' => 'Número',
        'bairro' => 'Bairro',
        'cidade' => 'Cidade',
        'uf' => 'UF',
        'celular' => 'Celular',
        'email' => 'E-mail',
        'tipo_deficiencia' => 'Tipo de Deficiência',
    ];
}

    public function messages()
    {
        return [
            'cpf.unique' => 'Já existe um candidato cadastrado com esse CPF.',
            'email.unique' => 'Já existe um candidato cadastrado com esse e-mail.',
            'cep.digits' => 'O campo CEP deve conter 8 dígitos.',
            'uf.size' => 'O campo UF deve conter 2 caracteres.',
            // 'telefone.phone' => 'O campo Telefone deve ser um número de telefone válido.',
            'celular.phone' => 'O campo Celular deve ser um número de telefone válido.',
            'tipo_deficiencia.required' => 'O campo Tipo de Deficiência é obrigatório quando a opção Deficiência é selecionada.',
        ];
    }
}
