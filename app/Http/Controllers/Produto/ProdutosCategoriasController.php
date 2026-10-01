<?php

namespace App\Http\Controllers\Produto;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriasStoreRequest;
use App\Http\Requests\CategoriasUpdateRequest;
use App\Models\Produto\ProdutoCategoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdutosCategoriasController extends Controller
{
    public function index(): View
    {
        $categorias = ProdutoCategoria::query()->paginate(10);

        return view('produtos.categoriasProduto.index', compact('categorias'));
    }

    public function criar(): View
    {
        return view('produtos.categoriasProduto.criar');
    }

    public function salvar(CategoriasStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $categoria = new ProdutoCategoria();
        $categoria->nome = $dados['nome'];
        $categoria->ativo = $dados['ativo'];
        $categoria->save();

        return redirect()->route('categoriasProduto.index')
            ->with('successo', 'Categoria cadastrada com sucesso!');
    }

    public function editar(ProdutoCategoria $categoria): View
    {
        return view('produtos.categoriasProduto.editar', compact('categoria'));
    }

    public function atualizar(CategoriasUpdateRequest $request, ProdutoCategoria $categoria): RedirectResponse
    {
        $dados = $request->validated();

        $categoria->nome = $dados['nome'];
        $categoria->ativo = $dados['ativo'];
        $categoria->update();

        return redirect()->route('categoriasProduto.index')
        ->with('status', 'Categoria atualizada com sucesso!');
    }

    public function excluir(ProdutoCategoria $categoria): RedirectResponse
    {
        if($categoria->produtos()->exists()) {
            return redirect()->route('categoriasProduto.index')
                ->with('erro', 'Não é possível excluir: há produtos com esta categoria.');
        }

        $categoria->delete();

        return redirect()->route('categoriasProduto.index')
            ->with('status', 'Categoria removida com sucesso!');
    }
}
