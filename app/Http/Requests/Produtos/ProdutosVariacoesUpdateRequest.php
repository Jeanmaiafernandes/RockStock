<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosVariacoesUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('variacao')->id;

        return [
            'ean'   => 'nullable|digits_between:8,14|unique:produtos_variacoes,ean,' . $id,
            'ativo' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ean.digits_between' => 'O EAN deve ter entre 8 e 14 números.',
            'ean.unique'         => 'Este EAN já está em outra variação.',
        ];
    }
}
