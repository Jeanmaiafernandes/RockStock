<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AutenticacaoController extends Controller
{
    public function exibirLogin(): View
    {
        return view('auth.entrar');
    }

    public function autenticar(Request $request): RedirectResponse
    {
        $credenciais = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credenciais, $request->boolean('lembrar'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('painel'));
        }

        return back()->withErrors([
            'email' => 'As credenciais informadas não conferem.',
        ])->onlyInput('email');
    }

    public function sair(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
