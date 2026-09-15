<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\AtualizarPerfilRequest;
use App\Http\Requests\Usuario\AtualizarSenhaRequest;
use App\Http\Requests\Usuario\CadastroRequest;
use App\Http\Requests\Usuario\EntrarRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UsuariosController extends Controller
{
    public function formCadastro(): View
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
            ->with('sucesso', 'Conta criada.');
    }

    public function formEntrar(): View
    {
        return view('usuarios.entrar');
    }

    public function entrar(EntrarRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $credenciais = [
            'email'    => $dados['email'],
            'password' => $dados['senha'],
        ];

        if (! Auth::attempt($credenciais, $request->boolean('lembrar'))) {
            return back()
                ->withErrors(['email' => 'E-mail ou senha incorretos.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('perfil'));
    }

    public function sair(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function perfil(Request $request): View
    {
        return view('usuarios.perfil', ['usuario' => $request->user()]);
    }

    public function atualizarPerfil(AtualizarPerfilRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return Redirect()->back()->with('sucesso', 'Dados atualizados.');
    }

    public function atualizarSenha(AtualizarSenhaRequest $request): RedirectResponse
    {
        $request->user()->update(['senha' => $request->senha]);

        $request->session()->put('password_hash_web', $request->user()->getAuthPassword());

        return redirect()->back()->with('sucesso', 'Senha alterada.');
    }
}
