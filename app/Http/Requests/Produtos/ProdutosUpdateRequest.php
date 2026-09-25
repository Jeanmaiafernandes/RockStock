<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'                 => 'required|string|max:200',
            'colecao'              => 'nullable|string|max:50',
            'descricao'            => 'nullable|string',
            'fornecedor_id'        => 'required|exists:fornecedores,id',
            'produto_categoria_id' => 'required|exists:produtos_categorias,id',
            'produto_status_id'    => 'required|exists:produtos_status,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'                 => 'Informe o nome do produto.',
            'nome.max'                      => 'O nome pode ter no máximo 200 caracteres.',
            'colecao.max'                   => 'A coleção pode ter no máximo 50 caracteres.',
            'fornecedor_id.required'        => 'Selecione o fornecedor.',
            'produto_categoria_id.required' => 'Selecione a categoria.',
            'produto_status_id.required'    => 'Selecione o status.',
        ];
    }
}
