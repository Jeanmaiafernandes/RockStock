<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Informe o nome.',
            'email.required'     => 'Informe o e-mail.',
            'email.unique'       => 'Esse e-mail já está cadastrado.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ];
    }
}
