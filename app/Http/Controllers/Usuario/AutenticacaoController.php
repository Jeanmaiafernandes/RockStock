<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\CadastroRequest;
use App\Http\Requests\Usuario\EntrarRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AutenticacaoController extends Controller
{
    public function formularioDeCadastro(): View
    {
        return view('usuarios.cadastro');
    }

    public function cadastrar(CadastroRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $usuario = new Usuario();
        $usuario->nome = $dados['nome'];
        $usuario->email = $dados['email'];
        $usuario->senha = $dados['senha'];
        $usuario->save();

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('perfil')
            ->with('success', 'Cadastro realizado com sucesso!');
    }

    public function formularioDeLogin(): View
    {
        return view('usuarios.entrar');
    }

    public function entrar(EntrarRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $credenciais = [
            'email' => $dados['email'],
            'password' => $dados['senha'],
        ];

        if (Auth::attempt($credenciais, $request->boolean('lembrar'))) {
            return back()
                ->withErrors(['email' => 'E-mail ou senha incorretos!'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('perfil'))
            ->with('sucesso', 'Usuario logado.');
    }

    public function sair(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
