<?php

namespace App\Http\Controllers;

use App\Http\Requests\FornecedoresStoreRequest;
use App\Http\Requests\FornecedoresUpdateRequest;
use App\Models\Fornecedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FornecedoresController extends Controller
{
    public function index(): View
    {
        $fornecedores = Fornecedor::query()
        ->select(['id', 'nome', 'contato', 'ativo'])
        ->paginate(10);
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function create(): View
    {
        return view('fornecedores.criar');
    }

    public function store(FornecedoresStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $fornecedor = new Fornecedor();
        $fornecedor->nome = $dados['nome'];
        $fornecedor->contato = $dados['contato'];
        $fornecedor->ativo = $dados['ativo'];
        $fornecedor->save();

        return redirect()->route('fornecedores.index', $fornecedor)
            ->with('successo', 'Fornecedor cadastrado com sucesso!');
    }

    public function edit(Fornecedor $fornecedor): View
    {
        return view('fornecedores.editar',
            ['fornecedor' => $fornecedor]);
    }

    public function update(FornecedoresUpdateRequest $request, Fornecedor $fornecedor): RedirectResponse
    {
        $dados = $request->validated();

        $fornecedor->nome = $dados['nome'];
        $fornecedor->contato = $dados['contato'];
        $fornecedor->ativo = $dados['ativo'];
        $fornecedor->update();

        return redirect()->route('fornecedores.index', $fornecedor)
            ->with('status', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy(Fornecedor $fornecedor): RedirectResponse
    {
        if($fornecedor->produtos()->exists()){
            return redirect()->route('fornecedores.index')
                ->with('erro', 'Não é possivel excluir: há produtos vinculados');
        }

        $fornecedor->delete();
        return back()->with('sucesso', 'Fornecedor excluído.')
            ->with('status');
    }
}
