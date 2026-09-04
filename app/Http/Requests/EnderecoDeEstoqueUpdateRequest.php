<?php

namespace App\Http\Requests;

use App\Models\EnderecoDeEstoque;
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
            'codigo' => Rule::unique('enderecos_de_estoque', 'codigo')->ignore($this->route('enderecoDeEstoque')),
            'tipo' => ['required', Rule::in(EnderecoDeEstoque::TIPOS)],
            'bloqueado' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.in' => 'Selecione um tipo válido.',
            'codigo.max' => 'O código tem no máximo 20 caracteres.',
            'codigo.unique' => 'Esse código já está cadastrado.',
        ];
    }
}
