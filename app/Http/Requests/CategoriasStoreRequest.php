<?php

namespace App\Http\Requests;

use App\Enums\StatusCategoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CategoriasStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'  => ['required','string','max:50', 'unique:produtos_categorias,id'],
//            'nome' => ['required', 'string', 'max:255', Rule::unique('produto_categorias')
//                ->ignore($this->categoria)],
            'ativo' => ['required', 'boolean'],
        ];
    }
}
