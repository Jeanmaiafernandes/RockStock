<?php

namespace App\Http\Controllers\Produto;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produtos\ProdutosTamanhosStoreRequest;
use App\Http\Requests\Produtos\ProdutosTamanhosUpdateRequest;
use App\Models\Produto\ProdutoTamanho;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdutosTamanhosController extends Controller
{
    public function index(): View
    {
        $tamanhos = ProdutoTamanho::query()
            ->withCount('variacoes')
            ->orderBy('ordem')
            ->paginate(10);

        return view('produtos.tamanhosProduto.index', compact('tamanhos'));
    }

    public function criar(): View
    {
        $proximaOrdem = ProdutoTamanho::query()->max('ordem') + 10;

        return view('produtos.tamanhosProduto.criar', compact('proximaOrdem'));
    }

    public function salvar(ProdutosTamanhosStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $tamanho = new ProdutoTamanho();
        $tamanho->nome = $dados['nome'];
        $tamanho->ordem = $dados['ordem'];
        $tamanho->save();

        return redirect()->route('tamanhos.index')
            ->with('sucesso', "Tamanho {$tamanho->nome} cadastrado.");
    }

    public function editar(ProdutoTamanho $tamanho): View
    {
        $tamanho->loadCount('variacoes');

        return view('produtos.tamanhosProduto.editar', compact('tamanho'));
    }

    public function atualizar(ProdutosTamanhosUpdateRequest $request, ProdutoTamanho $tamanho): RedirectResponse
    {
        $dados = $request->validated();

        $tamanho->nome = $dados['nome'];
        $tamanho->ordem = $dados['ordem'];
        $tamanho->save();

        return redirect()->route('tamanhos.index')
            ->with('sucesso', "Tamanho {$tamanho->nome} atualizado.");
    }

    public function excluir(ProdutoTamanho $tamanho): RedirectResponse
    {
        if ($tamanho->variacoes()->exists()) {
            return redirect()->route('tamanhos.index')
                ->with('erro', "O tamanho {$tamanho->nome} está em uso e não pode ser excluído.");
        }

        $tamanho->delete();

        return redirect()->route('tamanhos.index')
            ->with('sucesso', "Tamanho {$tamanho->nome} excluído.");
    }
}
