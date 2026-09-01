<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'senha' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Informe o e-mail.',
            'email.email'    => 'Informe um e-mail válido.',
            'senha.required' => 'Informe a senha.',
        ];
    }

    public function credenciais(): array
    {
        return [
            'email'    => $this->string('email')->toString(),
            'password' => $this->string('senha')->toString(),
        ];
    }
}
