<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutosStatusStoreRequest;
use App\Http\Requests\ProdutosStatusUpdateRequest;
use App\Models\ProdutoStatus;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

#[useModel(ProdutoStatus::class)]
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
        $request->validated();

        $produtoStatus = new ProdutoStatus();
        $produtoStatus->nome = $request['nome'];
        $produtoStatus->disponivel = $request['disponivel'];
        $produtoStatus->permite_saida = $request['permite_saida'];
        $produtoStatus->save();

        return redirect()->route('statusProdutos.index');
    }

    public function edit(ProdutoStatus $statusProduto): View
    {
        return view('statusProdutos.editar', compact('statusProduto'));
    }

    public function update(ProdutosStatusUpdateRequest $request, ProdutoStatus $statusProduto): RedirectResponse
    {
        $dados = $request->validated();

        $statusProduto->nome = $dados['nome'];
        $statusProduto->disponivel = $request->boolean('disponivel');
        $statusProduto->permite_saida = $request->boolean('permite_saida');
        $statusProduto->save();

        return redirect()->route('statusProdutos.index')
            ->with('successo', 'Status atualizado com sucesso!');
    }

    public function destroy(ProdutoStatus $statusProduto): RedirectResponse
    {
        if ($statusProduto->produtos()->exists()) {
            return redirect()->route('statusProdutos.index')
                ->with('erro', 'Não é possível excluir: há produtos com este status.');
        }

        $statusProduto->delete();
        return redirect()->route('statusProdutos.index');
    }
}
