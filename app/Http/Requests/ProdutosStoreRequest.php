<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'                    => ['required', 'string', 'max:255'],
            'quantidade'              => ['required', 'required', 'integer', 'min:0'],
            'sku'                     => ['required', 'string', 'max:255'],
            'ean'                     => ['nullable', 'string', 'min:8', 'max:13'],
            'descricao'               => ['required', 'string', 'min:5', 'max:255'],
            'produto_status_id'       => ['required', 'integer', 'exists:produtos_status,id'],
            'produto_categoria_id'    => ['required', 'integer', 'exists:produtos_categorias,id'],
        ];
    }
}
