<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\AtualizarPerfilRequest;
use App\Http\Requests\Usuario\AtualizarSenhaRequest;
use App\Http\Requests\Usuario\CadastroRequest;
use App\Http\Requests\Usuario\EntrarRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    public function formCadastro()
    {
        return view('usuarios.cadastro');
    }

    public function cadastrar(CadastroRequest $request)
    {
        $usuario = Usuario::query()->create($request->validated());

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('perfil')->with('sucesso', 'Conta criada.');
    }

    public function formEntrar()
    {
        return view('usuarios.entrar');
    }

    public function entrar(EntrarRequest $request)
    {
        $credenciais = [
            'email'    => $request->email,
            'password' => $request->senha,
        ];

        if (! Auth::attempt($credenciais, $request->boolean('lembrar'))) {
            return back()
                ->withErrors(['email' => 'E-mail ou senha incorretos.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('perfil'));
    }

    public function sair(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function perfil(Request $request)
    {
        return view('usuarios.perfil', ['usuario' => $request->user()]);
    }

    public function atualizarPerfil(AtualizarPerfilRequest $request)
    {
        $request->user()->update($request->validated());

        return back()->with('sucesso', 'Dados atualizados.');
    }

    public function atualizarSenha(AtualizarSenhaRequest $request)
    {
        $request->user()->update(['senha' => $request->senha]);

        $request->session()->regenerate();

        return back()->with('sucesso', 'Senha alterada.');
    }
}
