<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriasStoreRequest;
use App\Http\Requests\CategoriasUpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\ProdutoCategoria;
use Illuminate\View\View;

class ProdutosCategoriasController extends Controller
{
    public function index(): View
    {
        $categorias = ProdutoCategoria::query()->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('categorias.criar');
    }

    public function store(CategoriasStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $categoria = new ProdutoCategoria();
        $categoria->nome = $dados['nome'];
        $categoria->ativo = $dados['ativo'];
        $categoria->save();

        return redirect()->route('categorias.index')
            ->with('successo', 'Categoria cadastrada com sucesso!');
    }

    public function edit(ProdutoCategoria $categoria): View
    {
        return view('categorias.editar', compact('categoria'));
    }

    public function update(CategoriasUpdateRequest $request, ProdutoCategoria $categoria): RedirectResponse
    {
        $dados = $request->validated();

        $categoria->nome = $dados['nome'];
        $categoria->ativo = $dados['ativo'];
        $categoria->update();

        return redirect()->route('categorias.index')
        ->with('status', 'Categoria atualizada com sucesso!');
    }

    public function destroy(ProdutoCategoria $categoria): RedirectResponse
    {
        if($categoria->produtos()->exists()) {
            return redirect()->route('categorias.index')
                ->with('erro', 'Não é possível excluir: há produtos com esta categoria.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('status', 'Categoria removida com sucesso!');
    }
}
