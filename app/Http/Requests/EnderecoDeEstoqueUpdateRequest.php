<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnderecoDeEstoqueUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => [
                'required', 'string', 'max:255',
                Rule::unique('enderecos_de_estoque', 'codigo')->ignore($this->route('enderecoDeEstoque')),
            ],
            'tipo'      => ['required', 'string', 'max:255'],
            'bloqueado' => ['required', 'boolean'],
        ];
    }
}
