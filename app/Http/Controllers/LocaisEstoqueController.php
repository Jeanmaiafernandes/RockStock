<?php

namespace App\Http\Controllers;

use App\Enums\TipoLocalEstoque;
use App\Http\Requests\LocaisEstoqueStoreRequest;
use App\Http\Requests\LocaisEstoqueUpdateRequest;
use App\Models\LocalEstoque;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocaisEstoqueController extends Controller
{
    public function index(): View
    {
        $locais = LocalEstoque::query()
            ->withCount('enderecos')
            ->orderBy('nome')
            ->paginate(15);

        return view('locaisEstoque.index', compact('locais'));
    }

    public function criar(): View
    {
        $tipos = TipoLocalEstoque::opcoes();

        return view('locaisEstoque.criar', compact('tipos'));
    }

    public function salvar(LocaisEstoqueStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $local = new LocalEstoque();
        $local->nome = $dados['nome'];
        $local->tipo = $dados['tipo'];
        $local->ativo = $dados['ativo'];
        $local->save();

        return redirect()->route('locaisEstoque.index')
            ->with('sucesso', "Local {$local->nome} cadastrado.");
    }

    public function editar(LocalEstoque $localEstoque): View
    {
        $tipos = TipoLocalEstoque::opcoes();

        return view('locaisEstoque.editar', compact('localEstoque', 'tipos'));
    }

    public function atualizar(LocaisEstoqueUpdateRequest $request, LocalEstoque $localEstoque): RedirectResponse
    {
        $dados = $request->validated();

        $localEstoque->nome = $dados['nome'];
        $localEstoque->tipo = $dados['tipo'];
        $localEstoque->ativo = $dados['ativo'];
        $localEstoque->save();

        return redirect()->route('locaisEstoque.index')
            ->with('sucesso', "Local {$localEstoque->nome} atualizado.");
    }

    public function excluir(LocalEstoque $localEstoque): RedirectResponse
    {
        if ($localEstoque->enderecos()->exists()) {
            return redirect()->route('locaisEstoque.index')
                ->with('erro', "O local {$localEstoque->nome} tem endereços e não pode ser excluído.");
        }

        $localEstoque->delete();

        return redirect()->route('locaisEstoque.index')
            ->with('sucesso', "Local {$localEstoque->nome} excluído.");
    }
}
