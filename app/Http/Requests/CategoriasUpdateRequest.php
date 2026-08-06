<?php

namespace App\Http\Requests;

use App\Enums\StatusCategoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CategoriasUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'  => ['required','string','max:50'],
            'ativo' => ['required', 'boolean'],
        ];
    }
}
