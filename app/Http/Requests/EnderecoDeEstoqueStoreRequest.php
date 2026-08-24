<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoDeEstoqueStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo'    => ['required', 'string', 'max:255', 'unique:enderecos_de_estoque,codigo'],
            'tipo'      => ['required', 'string', 'max:255'],
            'bloqueado' => ['required', 'boolean'],
        ];
    }
}
