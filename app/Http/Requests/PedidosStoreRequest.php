<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidosStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'destino'            => ['required', 'string', 'max:255'],
            'observacao'         => ['nullable', 'string', 'max:255'],
            'statusPedido'       => ['required', 'in:rascunho,confirmado,cancelado'],

            'itens'              => ['required', 'array', 'min:1'],
            'itens.*.produto_id' => ['required', 'distinct', 'exists:produtos,id'],
            'itens.*.quantidade' => ['required', 'integer', 'min:1', 'max:65535'],
        ];
    }

    public function attributes(): array
    {
        return [
            'statusPedido'       => 'status',
            'itens.*.produto_id' => 'produto',
            'itens.*.quantidade' => 'quantidade',
        ];
    }

    public function messages(): array
    {
        return [
            'itens.required'                => 'Adicione ao menos um item ao pedido.',
            'itens.min'                     => 'Adicione ao menos um item ao pedido.',
            'itens.*.produto_id.required'   => 'Selecione o produto na linha :position.',
            'itens.*.produto_id.distinct'   => 'Este produto foi adicionado mais de uma vez.',
            'itens.*.quantidade.min'        => 'A quantidade precisa ser pelo menos 1.',
        ];
    }
}
