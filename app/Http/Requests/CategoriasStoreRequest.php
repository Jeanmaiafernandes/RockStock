<?php

namespace App\Http\Requests;

use App\Enums\StatusCategoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'ativo' => [Rule::enum(StatusCategoria::class)
                ->only([StatusCategoria::Inativo, StatusCategoria::Ativo])],
        ];
    }
}
