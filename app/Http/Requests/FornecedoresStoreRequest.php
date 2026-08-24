<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FornecedoresStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'    => ['required', 'string'],
            'contato' => ['required', 'string'],
            'ativo'   => ['required', 'boolean'],
        ];
    }
}
