<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerfilUsuarioRequest extends FormRequest
{
    protected $errorBag = 'perfil';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('usuarios', 'email')->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'  => 'Informe o nome.',
            'email.required' => 'Informe o e-mail.',
            'email.email'    => 'Informe um e-mail válido.',
            'email.unique'   => 'Esse e-mail já está em uso por outra conta.',
        ];
    }
}
