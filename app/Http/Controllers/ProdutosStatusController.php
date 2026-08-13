<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutosStatusStoreRequest;
use App\Http\Requests\ProdutosStatusUpdateRequest;
use App\Models\ProdutoStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdutosStatusController extends Controller
{
    public function index(): View
    {
        $statusProdutos = ProdutoStatus::query()
            ->select(['id', 'nome', 'disponivel', 'permite_saida'])
            ->orderBy('nome')
            ->paginate(10);

        return view('statusProdutos.index', compact('statusProdutos'));
    }

    public function create(): View
    {
        return view('statusProdutos.criar');
    }

    public function store(ProdutosStatusStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $statusProduto = new ProdutoStatus();
        $statusProduto->nome = $dados['nome'];
        $statusProduto->disponivel = $dados['disponivel'];
        $statusProduto->permite_saida = $dados['permite_saida'];
        $statusProduto->save();

        return redirect()->route('statusProdutos.index')
            ->with('successo', 'Produto cadastrado com sucesso!');
    }

    public function edit(ProdutoStatus $statusProduto): View
    {
        return view('statusProdutos.editar', compact('statusProduto'));
    }

    public function update(ProdutosStatusUpdateRequest $request, ProdutoStatus $statusProduto): RedirectResponse
    {
        $dados = $request->validated();

        $statusProduto->nome = $dados['nome'];
        $statusProduto->disponivel = $dados['disponivel'];
        $statusProduto->permite_saida = $dados['permite_saida'];
        $statusProduto->update();

        return redirect()->route('statusProdutos.index')
            ->with('status', 'Status atualizado com sucesso!');
    }

    public function destroy(ProdutoStatus $statusProduto): RedirectResponse
    {
        if ($statusProduto->produtos()->exists()) {
            return redirect()->route('statusProdutos.index')
                ->with('erro', 'Não é possível excluir: há produtos com este status.');
        }

        $statusProduto->delete();
        return redirect()->route('statusProdutos.index')
            ->with('status', 'Status removido com sucesso!');
    }
}
