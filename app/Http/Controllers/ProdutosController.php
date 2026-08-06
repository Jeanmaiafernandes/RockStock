<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutosStoreRequest;
use App\Http\Requests\ProdutosUpdateRequest;
use App\Models\Produto;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoStatus;
use http\Exception;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProdutosController extends Controller
{
    public function index(): View
    {
        $produtos = Produto::query()
            ->with(['categoria', 'Status'])
            ->select(['id', 'nome', 'descricao',
                'quantidade', 'sku', 'ean', 'produto_categoria_id', 'produto_status_id'])
            ->paginate(10);
        return view('produtos.index', compact('produtos'));
    }

    public function create(): View
    {
        return view('produtos.criar', [
            'categorias' => ProdutoCategoria::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
            'status'     => ProdutoStatus::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
        ]);
    }

    public function store(ProdutosStoreRequest $request): RedirectResponse
    {
        $produto = new Produto();
        $produto->nome = $request['nome'];
        $produto->descricao = $request['descricao'];
        $produto->sku  = $request['sku'];
        $produto->ean  = $request['ean'];
        $produto->quantidade = $request['quantidade'];
        $produto->produto_status_id = $request['produto_status_id'];
        $produto->produto_categoria_id = $request['produto_categoria_id'];
        $produto->save();

        return redirect()->route('produtos.index');
    }

    public function  show(Produto $produto): View
    {
        $produto->load(['categoria', 'Status']);

        return view('produtos.visualizar',
            compact('produto'));
    }

    public function edit(Produto $produto): View
    {
        return view('produtos.editar', [
            'produto'    => $produto,
            'categorias' => ProdutoCategoria::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
            'status'     => ProdutoStatus::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
        ]);
    }

    public function update(ProdutosUpdateRequest $request, Produto $produto): RedirectResponse
    {
        $produto->update($request->validated());

        return redirect()->route('produtos.index');
    }

    public function destroy(Produto $produto): RedirectResponse
    {
        if($produto->pedidosItens()->exists()) {
            return redirect()->route('produtos.index')
            ->with('erro', 'Não é possivel excluir: Há pedidos com este produto.');
        }

        $produto->delete();

        return redirect()->route('produtos.index');
    }
}
