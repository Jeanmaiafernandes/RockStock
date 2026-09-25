<?php

namespace App\Http\Requests\Produtos;

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
            'referencia'           => 'required|string|max:30|unique:produtos,referencia',
            'nome'                 => 'required|string|max:200',
            'colecao'              => 'nullable|string|max:50',
            'descricao'            => 'nullable|string',
            'fornecedor_id'        => 'required|exists:fornecedores,id',
            'produto_categoria_id' => 'required|exists:produtos_categorias,id',
            'produto_status_id'    => 'required|exists:produtos_status,id',

            // Grade: opcional, mas se vier cor precisa vir tamanho (e vice-versa)
            'cores'      => 'nullable|array|required_with:tamanhos',
            'cores.*'    => 'string|max:50|distinct',
            'tamanhos'   => 'nullable|array|required_with:cores',
            'tamanhos.*' => 'exists:produtos_tamanhos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'referencia.required'           => 'Informe a referência.',
            'referencia.max'                => 'A referência pode ter no máximo 30 caracteres.',
            'referencia.unique'             => 'Já existe um produto com esta referência.',
            'nome.required'                 => 'Informe o nome do produto.',
            'nome.max'                      => 'O nome pode ter no máximo 200 caracteres.',
            'colecao.max'                   => 'A coleção pode ter no máximo 50 caracteres.',
            'fornecedor_id.required'        => 'Selecione o fornecedor.',
            'produto_categoria_id.required' => 'Selecione a categoria.',
            'produto_status_id.required'    => 'Selecione o status.',
            'cores.required_with'           => 'Informe ao menos uma cor.',
            'cores.*.max'                   => 'Cada cor pode ter no máximo 50 caracteres.',
            'cores.*.distinct'              => 'Há cores repetidas.',
            'tamanhos.required_with'        => 'Marque ao menos um tamanho.',
        ];
    }
}
