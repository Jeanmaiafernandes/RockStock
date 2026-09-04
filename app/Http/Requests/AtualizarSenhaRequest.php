<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AtualizarSenhaRequest extends FormRequest
{
    protected $errorBag = 'senha';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'senha_atual' => ['required', 'string', 'current_password'],
            'senha'       => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'senha_atual.required'         => 'Informe a senha atual.',
            'senha_atual.current_password' => 'A senha atual não confere.',
            'senha.required'               => 'Informe a nova senha.',
            'senha.confirmed'              => 'A confirmação de senha não confere.',
        ];
    }
}
