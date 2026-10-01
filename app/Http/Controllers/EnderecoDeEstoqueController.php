<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoDeEstoque\EnderecoDeEstoqueStoreRequest;
use App\Http\Requests\EnderecoDeEstoque\EnderecoDeEstoqueUpdateRequest;
use App\Models\EnderecoDeEstoque;
use App\Models\LocalEstoque;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnderecoDeEstoqueController extends Controller
{
    public function index(): View
    {
        $enderecos = EnderecoDeEstoque::query()
            ->with('local')
            ->orderBy('local_estoque_id')
            ->orderBy('codigo')
            ->paginate(15);

        return view('enderecoDeEstoque.index', [
            'enderecos' => $enderecos,
            'tipos'     => EnderecoDeEstoque::TIPOS,
        ]);
    }

    public function criar(): View
    {
        return view('enderecoDeEstoque.criar', [
            'locais' => LocalEstoque::where('ativo', true)->orderBy('nome')->pluck('nome', 'id'),
            'tipos'  => EnderecoDeEstoque::TIPOS,
        ]);
    }

    public function salvar(EnderecoDeEstoqueStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $endereco = new EnderecoDeEstoque();
        $endereco->local_estoque_id = $dados['local_estoque_id'];
        $endereco->codigo = strtoupper($dados['codigo']);
        $endereco->tipo = $dados['tipo'];
        $endereco->ativo = $dados['ativo'];
        $endereco->save();

        return redirect()->route('enderecoDeEstoque.index')
            ->with('sucesso', "Endereço {$endereco->codigo} cadastrado.");
    }

    public function editar(EnderecoDeEstoque $enderecoDeEstoque): View
    {
        return view('enderecoDeEstoque.editar', [
            'enderecoDeEstoque' => $enderecoDeEstoque,
            'locais'            => LocalEstoque::orderBy('nome')->pluck('nome', 'id'),
            'tipos'             => EnderecoDeEstoque::TIPOS,
        ]);
    }

    public function atualizar(EnderecoDeEstoqueUpdateRequest $request, EnderecoDeEstoque $enderecoDeEstoque): RedirectResponse
    {
        $dados = $request->validated();

        $enderecoDeEstoque->local_estoque_id = $dados['local_estoque_id'];
        $enderecoDeEstoque->codigo = strtoupper($dados['codigo']);
        $enderecoDeEstoque->tipo = $dados['tipo'];
        $enderecoDeEstoque->ativo = $dados['ativo'];
        $enderecoDeEstoque->save();

        return redirect()->route('enderecoDeEstoque.index')
            ->with('sucesso', "Endereço {$enderecoDeEstoque->codigo} atualizado.");
    }

    public function excluir(EnderecoDeEstoque $enderecoDeEstoque): RedirectResponse
    {
        if ($enderecoDeEstoque->temMovimentacoes()) {
            return redirect()->route('enderecoDeEstoque.index')
                ->with('erro', "O endereço {$enderecoDeEstoque->codigo} já tem movimentações. Desative-o em vez de excluir.");
        }

        $enderecoDeEstoque->delete();

        return redirect()->route('enderecoDeEstoque.index')
            ->with('sucesso', "Endereço {$enderecoDeEstoque->codigo} excluído.");
    }
}
