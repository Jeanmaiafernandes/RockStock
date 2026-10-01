<?php

namespace App\Http\Requests\EnderecoDeEstoque;

use App\Models\EnderecoDeEstoque;
use Illuminate\Foundation\Http\FormRequest;

class EnderecoDeEstoqueStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tipos = implode(',', array_keys(EnderecoDeEstoque::TIPOS));

        return [
            'local_estoque_id' => 'required|exists:locais_estoque,id',
            // O código não pode repetir dentro do mesmo local
            'codigo'           => 'required|string|max:20|unique:enderecos_de_estoque,codigo,NULL,id,local_estoque_id,' . $this->local_estoque_id,
            'tipo'             => 'required|in:' . $tipos,
            'ativo'            => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'local_estoque_id.required' => 'Selecione o local.',
            'codigo.required'           => 'Informe o código do endereço.',
            'codigo.max'                => 'O código pode ter no máximo 20 caracteres.',
            'codigo.unique'             => 'Já existe um endereço com este código neste local.',
            'tipo.required'             => 'Selecione o tipo.',
            'tipo.in'                   => 'Tipo inválido.',
        ];
    }
}
