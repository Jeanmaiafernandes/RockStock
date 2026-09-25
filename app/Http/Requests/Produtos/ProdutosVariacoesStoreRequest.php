<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosVariacoesStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cores'      => 'required|array',
            'cores.*'    => 'string|max:50|distinct',
            'tamanhos'   => 'required|array',
            'tamanhos.*' => 'exists:produtos_tamanhos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'cores.required'    => 'Informe ao menos uma cor.',
            'cores.*.max'       => 'Cada cor pode ter no máximo 50 caracteres.',
            'cores.*.distinct'  => 'Há cores repetidas.',
            'tamanhos.required' => 'Marque ao menos um tamanho.',
        ];
    }
}
