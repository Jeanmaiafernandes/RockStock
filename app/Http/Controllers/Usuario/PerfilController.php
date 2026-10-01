<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\AtualizarPerfilRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function perfil(Request $request): View
    {
        return view('usuarios.perfil', ['usuario' => $request->user()]);
    }

    public function atualizarPerfil(AtualizarPerfilRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return redirect()->back()->with('sucesso', 'Dados atualizados.');
    }
}
