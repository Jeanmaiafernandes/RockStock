<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistroRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegistroController extends Controller
{
    public function exibirRegistro(): View
    {
        return view('auth.registrar');
    }

    public function registrar(RegistroRequest $request): RedirectResponse
    {
        $usuario = User::query()->create($request->validated());

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('painel');
    }
}
