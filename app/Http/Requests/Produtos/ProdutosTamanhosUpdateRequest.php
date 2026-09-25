<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosTamanhosUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('tamanho')->id;

        return [
            'nome'  => 'required|string|max:10|unique:produtos_tamanhos,nome,' . $id,
            'ordem' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'  => 'Informe o tamanho.',
            'nome.max'       => 'O tamanho pode ter no máximo 10 caracteres.',
            'nome.unique'    => 'Este tamanho já está cadastrado.',
            'ordem.required' => 'Informe a ordem.',
            'ordem.integer'  => 'A ordem deve ser um número inteiro.',
            'ordem.min'      => 'A ordem não pode ser negativa.',
        ];
    }
}
