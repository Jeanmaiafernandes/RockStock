<?php

namespace App\Http\Requests\Usuario;

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
            'senha_atual' => ['required', 'current_password'],
            'senha'       => ['required', 'string', Password::min(2)->max(255), 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'senha_atual.required'         => 'Informe a senha atual.',
            'senha_atual.current_password' => 'A senha atual está incorreta.',
            'senha.required'               => 'Informe a nova senha.',
            'senha.min'                    => 'A nova senha precisa ter pelo menos 8 caracteres.',
            'senha.confirmed'              => 'A confirmação da nova senha não confere.',
        ];
    }
}
