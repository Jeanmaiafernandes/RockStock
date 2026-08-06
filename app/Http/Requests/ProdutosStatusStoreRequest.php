<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosStatusStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'  => ['required', 'string', 'max:50'],
            'disponivel' => ['required', 'boolean'],
            'permite_saida' => ['required', 'boolean'],
        ];
    }
}
