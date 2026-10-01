<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\AtualizarSenhaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class SenhaController extends Controller
{
    public function atualizarSenha(AtualizarSenhaRequest $request): RedirectResponse
    {
        $request->user()->update([
            'senha' => Hash::make($request->senha)
        ]);

        $request->session()->put('password_hash_web', $request->user()->getAuthPassword());

        return redirect()->back()->with('sucesso', 'Dados atualizados.');
    }
}
