<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => 'nullable', // status da pre-matricula
            'data_inscricao' => 'nullable',
            'data_aprovacao' => 'nullable',
            'data_rejeicao' => 'nullable',
            'data_cancelamento' => 'nullable',
            'data_expiracao' => 'nullable',
            'data_revalidacao' => 'nullable',
            'data_renovacao' => 'nullable',
            'data_transferência' => 'nullable',
            'data_reclassificacao' => 'nullable',
            'data_reemissao' => 'nullable',

        ];
    }
}
