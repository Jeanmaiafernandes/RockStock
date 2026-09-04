<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarSenhaRequest;
use App\Http\Requests\PerfilUsuarioRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerfilUsuarioController extends Controller
{
    public function index(Request $request): View
    {
        return view('perfilUsuario.index', [
            'usuario' => $request->user(),
        ]);
    }

    public function atualizar(PerfilUsuarioRequest $request): RedirectResponse
    {
        $usuario = $request->user();

        $usuario->fill($request->validated());

        if ($usuario->isDirty('email')) {
            $usuario->email_verified_at = null;
        }

        $usuario->save();

        return redirect()
            ->route('perfil.index')
            ->with('sucesso', 'Perfil atualizado.');
    }

    public function atualizarSenha(AtualizarSenhaRequest $request): RedirectResponse
    {
        $request->user()->update([
            'senha' => $request->validated()['senha'],
        ]);

        $request->session()->regenerate();

        return redirect()
            ->route('perfil.index')
            ->with('sucesso', 'Senha alterada.');
    }
}
