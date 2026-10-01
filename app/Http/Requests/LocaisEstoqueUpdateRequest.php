<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\TipoLocalEstoque;
use Illuminate\Validation\Rule;

class LocaisEstoqueUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'tipo' => [Rule::enum(TipoLocalEstoque::class)
                ->only([
                    TipoLocalEstoque::Cd,
                    TipoLocalEstoque::Loja,
                ])],
            'ativo' => ['required', 'boolean'],
        ];
    }
}
