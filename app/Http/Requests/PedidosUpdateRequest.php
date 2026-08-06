<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PedidosUpdateRequest extends FormRequest
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
}
