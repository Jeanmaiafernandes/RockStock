<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function mostrarLoginForm(): View
    {
        return view('auth.entrar');
    }

    public function entrar(LoginRequest $request): RedirectResponse
    {
        $autenticou = Auth::attempt(
            $request->credenciais(),
            $request->boolean('lembrar')
        );

        if (! $autenticou) {
            throw ValidationException::withMessages([
                'email' => 'As credenciais informadas não conferem.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('painel'));
    }
}
