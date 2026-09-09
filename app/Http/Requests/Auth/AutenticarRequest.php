<?php

namespace App\Http\Requests\Auth;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AutenticarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'senha' => ['required', 'string', 'confirmed', Password::defaults()],
                ];
    }

    public function messages(): array
    {
        return [
            'nome.required'   => 'Informe o nome.',
            'email.required'  => 'Informe o e-mail.',
            'email.email'     => 'Informe um e-mail válido.',
            'email.unique'    => 'Esse e-mail já está cadastrado.',
            'senha.required'  => 'Informe a senha.',
            'senha.confirmed' => 'A confirmação de senha não confere.',
        ];
    }

    public function dadosDoUsuario(): array
    {
        return [
            'nome'  => $this->string('nome')->toString(),
            'email' => $this->string('email')->toString(),
            'senha' => $this->string('senha')->toString(),
        ];
    }

    public function boot(): void
    {
        RateLimiter::for('login', function () {
            return Limit::perMinute(10);
        });
    }
}
