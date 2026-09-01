<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AutenticarRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AutenticarController extends Controller
{
    public function mostrarRegistroForm(): View
    {
        return view('auth.registrar');
    }

    public function registrar(AutenticarRequest $request): RedirectResponse
    {
        $usuario = Usuario::query()->create($request->dadosDoUsuario());

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()->route('painel');
    }
}
