<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoDeEstoqueStoreRequest;
use App\Http\Requests\EnderecoDeEstoqueUpdateRequest;
use App\Models\EnderecoDeEstoque;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnderecoDeEstoqueController extends Controller
{
    public function index(): View
    {
        $enderecoDeEstoque = EnderecoDeEstoque::query()
            ->select(['id', 'codigo', 'tipo', 'bloqueado'])
            ->paginate(10);

        return view('enderecoDeEstoque.index', compact('enderecoDeEstoque'));
    }

    public function create(): View
    {
        return view('enderecoDeEstoque.criar');
    }

    public function store(EnderecoDeEstoqueStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $enderecoDeEstoque = new EnderecoDeEstoque();
        $enderecoDeEstoque->codigo = $dados['codigo'];
        $enderecoDeEstoque->tipo = $dados['tipo'];
        $enderecoDeEstoque->bloqueado = $dados['bloqueado'];
        $enderecoDeEstoque->save();

        return redirect()->route('enderecoDeEstoque.index',
            $enderecoDeEstoque) ->with('status', 'Endereco de estoque cadastrado com sucesso!');
    }

    public function edit(EnderecoDeEstoque $enderecoDeEstoque): View
    {
        return view('enderecoDeEstoque.editar',
        ['enderecoDeEstoque' => $enderecoDeEstoque]);
    }

    public function update(EnderecoDeEstoqueUpdateRequest $request,
        EnderecoDeEstoque $enderecoDeEstoque): RedirectResponse
    {
        $dados = $request->validated();

        $enderecoDeEstoque->codigo = $dados['codigo'];
        $enderecoDeEstoque->tipo = $dados['tipo'];
        $enderecoDeEstoque->bloqueado = $dados['bloqueado'];
        $enderecoDeEstoque->update();

        return redirect()->route('enderecoDeEstoque.index',
            $enderecoDeEstoque)->with('status', 'Endereco de estoque editado com sucesso!');
    }

    public function destroy(EnderecoDeEstoque $enderecoDeEstoque): RedirectResponse
    {
        if ($enderecoDeEstoque->produtos()->exists()) {
            return redirect()->route('enderecoDeEstoque.index')
                ->with('erro', 'Não é possivel excluir: há produtos vinculados');
        }

        $enderecoDeEstoque->delete();
        return back()->with('sucesso', 'Endereço de Estoque apagado com sucesso!')
            ->with('status');
    }
}
